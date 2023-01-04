<?php

use Madhouse\HttpFoundation\FileBag;
use Madhouse\HttpFoundation\File\Exception\FileException;

class Madhouse_Messenger_Controllers_Web extends WebSecBaseModel {

    private $dao;
    private $user;

    public function __construct() {
        // Handling referers for inbox and thread page.
        if(!osc_get_http_referer()) {
            // No referer set, neither in session nor in $_SERVER.
            // Set one as the default.
            if(Params::getParam('route') == mdh_current_plugin_name() . "_thread") {
                Session::newInstance()->_setReferer(mdh_messenger_thread_url(Params::getParam("id")));
            } else {
                Session::newInstance()->_setReferer(mdh_messenger_inbox_url());
            }
        }

        parent::__construct();

        // Create a Madhouse_User object for the logged user.
        $this->user = Madhouse_Utils_Models::findUserByPrimaryKey(osc_logged_user_id());

        $this->threads = Madhouse_Messenger_Services_ThreadService::newInstance();
        $this->resources = Madhouse_Messenger_Services_ResourceUploader::newInstance();
    }

    /**
     * Shows authentificate fail page with the proper message.
     *  (Don't empty the session to keep the referer)
     * @override SecBaseModel
     */
    function showAuthFailPage()
    {
        if (Params::getParam("message", false, false) != "" || Params::getParam("subject") != "") {
            Session::newInstance()->_setForm('pp_message', Params::getParam("message", false, false));
            Session::newInstance()->_setForm('pp_subject', Params::getParam("subject"));
            Session::newInstance()->_keepForm('pp_message');
            Session::newInstance()->_keepForm('pp_subject');
        }

        osc_add_flash_info_message(__("Please login to access to your messages", mdh_current_plugin_name()));
        parent::showAuthFailPage();
    }


    /**
     * Stub method.
     *  (Don't empty the session to keep the referer)
     * @override SecBaseModel
     */
    function logout() {
    }

    /**
     * Business control for Madhouse Messenger Plugin for OSClass.
     */
    public function doModel() {
        parent::doModel();

        // Export the viewer, just in case we need it.
        $this->_exportVariableToView("mdh_viewer", $this->user);
        $this->_exportVariableToView("user", User::newInstance()->findByPrimaryKey(osc_logged_user_id()));

        switch(Params::getParam("route")) {
            // INBOX
            case mdh_current_plugin_name() . "_inbox":

                // Page number.
                $page = Params::getParam("p");
                if(!isset($page) || empty($page)) {
                  $page = 1;
                  Params::setParam("p", $page);
                }

                // Number of thread displayed per page.
                $num = Params::getParam("n");
                if(!isset($num) || empty($num)) {
                  $num = 10;
                  Params::setParam("n", $num);
                }


                $params = array();
                $params["user"] = $this->user;

                $label = Params::getParam("label");
                if(!isset($label) || empty($label)) {
                    $label = "inbox";
                    Params::setParam("label", $label);
                }

                try {
                    // First try within system labels (such as inbox, archive, spam...).
                    $olabel = Madhouse_Messenger_Models_Labels::newInstance()->findByName($label);
                } catch(Madhouse_NoResultsException $e) {
                    try {
                        // Try within user's labels and let the exception handling to controller.
                        $olabel = Madhouse_Messenger_Models_Labels::newInstance()->findByName($label, $this->user);
                    } catch (Madhouse_NoResultsException $e) {
                        mdh_handle_error(
                            __("The requested label does not exist", mdh_current_plugin_name()),
                            mdh_messenger_inbox_url()
                        );
                    }
                }

                $params["label"] = $olabel;

                $item = Params::getParam("item");
                if(isset($item) && !empty($item)) {
                    $params["item"] = $item;
                }

                // Filter can only be unread because we can't create a route with filter[] param
                $filters = array();
                if (Params::getParam("filter") != "" && !is_array(Params::getParam("filter"))) {
                    array_push($filters, Params::getParam("filter"));
                }


                foreach ($filters as $key => $filter) {
                    if ($filter == "unread") {
                        $params["unread"] = true;
                    }
                }

                /*
                 * Find all the threads in the inbox.
                 */
                $threads = $this->threads->findAll(
                    $params,
                    array("iDisplayPage" => $page, "iDisplayLength" => $num)
                );

                // Load and send view object to the view.
                $this->_exportVariableToView(
                    "mdh_threads",
                    $threads
                );

                // Exports the total number of threads to the view.
                $this->_exportVariableToView(
                    "mdh_threads_count",
                    Madhouse_Messenger_Models_Threads::newInstance()->countByUser(
                        $this->user,
                        $params
                    )
                );

                $this->_exportVariableToView(
                    "mdh_current_label",
                    $olabel
                );

                $this->_exportVariableToView(
                    "mdh_thread_labels",
                    Madhouse_Messenger_Models_Labels::newInstance()->findByUser($this->user)
                );

                if(isset($params["item"]) && $params["item"] != 0) {
                    // An item is linked or has been linked and is not anymore.
                    $item = Item::newInstance()->findByPrimaryKey($params["item"]);
                    if(count($item) != 0) {
                       $item = new Madhouse_Item(
                            $item,
                            ItemResource::newInstance()->getResource($params["item"])
                        );
                       $this->_exportVariableToView("mdh_current_item", $item);
                    }
                }

                $items = Item::newInstance()->findItemTypesByUserID($this->user->getId(), 0, null, 'all');
                $this->_exportVariableToView('items', $items);

                osc_run_hook("mdh_show_inbox");
            break;
            /**
             * do=thread_label
             * Archives a thread.
             * @param id id of the thread to archive.
             */
            case mdh_current_plugin_name() . "_thread_label_add":
                // Getting thread from database.
                $thread = self::findThread(Params::getParam("id"));
                $label = self::findLabel(Params::getParam("label"));

                try {
                    // User $user sets status $status to thread $id.
                    Madhouse_Messenger_ThreadActions::addLabel(
                        $thread,
                        $this->user,
                        $label
                    );

                    // Redirects to the thread itself.
                    mdh_handle_ok(
                        __(sprintf(__("Successfully moved thread to %s", mdh_current_plugin_name()), $label->getTitle()), mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                    $this->redirectTo(osc_get_http_referer());
                } catch(Madhouse_Messenger_ForbiddenOperationException $e) {
                    mdh_handle_warning(
                        sprintf(
                            __("Thread is already marked as %s", mdh_current_plugin_name()),
                            $label->getTitle()
                        ),
                        osc_get_http_referer()
                    );
                } catch(Madhouse_AuthorizationException $e) {
                    mdh_handle_error(
                        __("Nice try, but you can't do that!", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                } catch(Madhouse_QueryFailedException $e) {
                    mdh_handle_error(
                        __("An error occured while performing the task", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                }
            break;
            case mdh_current_plugin_name() . "_thread_label_remove":
                $thread = self::findThread(Params::getParam("id"));
                $label = self::findLabel(Params::getParam("label"));

                try {
                    // User $user sets status $status to thread $id.
                    Madhouse_Messenger_ThreadActions::removeLabel(
                        $thread,
                        $label,
                        $this->user
                    );

                    // Redirects to the thread itself.
                    mdh_handle_ok(
                        __(sprintf(__("Successfully removed thread of '%s'", mdh_current_plugin_name()), $label->getTitle()), mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                    $this->redirectTo(osc_get_http_referer());
                } catch(Madhouse_Messenger_ForbiddenOperationException $e) {
                    mdh_handle_warning(
                        sprintf(
                            __("Thread is not marked as %s", mdh_current_plugin_name()),
                            $label->getTitle()
                        ),
                        osc_get_http_referer()
                    );
                } catch(Madhouse_AuthorizationException $e) {
                    mdh_handle_error(
                        __("Nice try, but you can't do that!", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                } catch(Madhouse_QueryFailedException $e) {
                    mdh_handle_error(
                        __("An error occured while performing the task", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                }
            break;
            /**
             * do=thread_block_user
             * Block a user
             * @param id of the user to block.
             */
            case mdh_current_plugin_name() . "_user_block_user":
                // Find the user to block.
                $blockedUserId = Params::existParam("id") ? Params::getParam("id") : null;
                $threadId      = Params::existParam("thread_id") ? Params::getParam("thread_id") : null;

                try {

                    if (!is_null($threadId)) {
                        $thread = self::findThread($threadId);
                        $threadView = new Madhouse_Messenger_Views_ThreadSummary($this->user, $thread, 0);
                        $blockedUser = $threadView->getOther();
                    } elseif ($blockedUserId === "") {
                        $blockedUser = new Madhouse_User(array());
                    } elseif (filter_var($blockedUserId, FILTER_VALIDATE_INT) === false) {
                        // User to block is probably a non registered user.
                        $blockedUser = new Madhouse_User(
                            array(
                                "s_name" => __("Blocked User", "madhouse_messenger"), // @TODO
                                "s_email" => Params::getParam("id"),
                            )
                        );
                    } else {
                        // User to block is registered.
                        $blockedUser = Madhouse_Utils_Models::findUserByPrimaryKey(Params::getParam("id"));

                    }

                    // Block the user.
                    $blockedUser = Madhouse_Messenger_Services_UserService::newInstance()->blockUser($this->user, $blockedUser);

                    // Redirects to the thread itself.
                    mdh_handle_ok(
                        sprintf(__("Successfully blocked user %s", mdh_current_plugin_name()), $blockedUser->getName()),
                        osc_get_http_referer()
                    );
                } catch(Madhouse_Messenger_ForbiddenOperationException $e) {
                    mdh_handle_warning(
                        sprintf(
                            __("This user is already blocked", mdh_current_plugin_name())
                        ),
                        osc_get_http_referer()
                    );
                } catch(Madhouse_AuthorizationException $e) {
                    mdh_handle_error(
                        __("Nice try, but you can't do that!", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                } catch(Madhouse_QueryFailedException $e) {
                    mdh_handle_error(
                        __("An error occured while performing the task", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                }
            break;
            /**
             * do=thread_block_user
             * Block a user
             * @param id of the user to unblock.
             */
            case mdh_current_plugin_name() . "_user_unblock_user":
                // Find the user to block.

                $threadId      = Params::existParam("thread_id") ? Params::getParam("thread_id") : null;

                try {
                    if (!is_null($threadId)) {
                        $thread = self::findThread($threadId);
                        $threadView = new Madhouse_Messenger_Views_ThreadSummary($this->user, $thread, 0);
                        $blockedUser = $threadView->getOther();
                    } elseif (is_numeric(Params::getParam("id"))) {
                        $blockedUser = Madhouse_Utils_Models::findUserByPrimaryKey(Params::getParam("id"));
                    } else {
                        $blockedUser = new Madhouse_User(
                            array(
                                "s_email" => Params::getParam("id"),
                            )
                        );
                    }

                    // User $user sets status $status to thread $id.
                    Madhouse_Messenger_Services_UserService::newInstance()->unblockUser($this->user, $blockedUser);

                    // Redirects to the thread itself.
                    mdh_handle_ok(
                        sprintf(__("Successfully unblocked user %s", mdh_current_plugin_name()), $blockedUser->getName()),
                        osc_get_http_referer()
                    );
                    $this->redirectTo(osc_get_http_referer());
                } catch(Madhouse_Messenger_ForbiddenOperationException $e) {
                    mdh_handle_warning(
                        sprintf(
                            __("This user is already unblocked", mdh_current_plugin_name())
                        ),
                        osc_get_http_referer()
                    );
                } catch(Madhouse_AuthorizationException $e) {
                    mdh_handle_error(
                        __("Nice try, but you can't do that!", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                } catch(Madhouse_QueryFailedException $e) {
                    mdh_handle_error(
                        __("An error occured while performing the task", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                }
            break;
            /**
             * do=thread_mark_unread
             * Mark a thread as unread
             * @param id of the thread to mark as unread.
             */
            case mdh_current_plugin_name() . "_thread_mark_unread":

                try {

                    // Find the thread
                    $thread = self::findThread(Params::getParam("id"));

                    // User $user sets status $status to thread $id.
                    Madhouse_Messenger_ThreadActions::markAsUnread($thread, $this->user);

                    // Redirects to the thread itself.
                    mdh_handle_ok(
                        sprintf(__("Successfully mark a thread as unread", mdh_current_plugin_name())),
                        osc_get_http_referer()
                    );
                    $this->redirectTo(osc_get_http_referer());
                } catch(Madhouse_AuthorizationException $e) {
                    mdh_handle_error(
                        __("Nice try, but you can't do that!", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                } catch(Exception $e) {
                    mdh_handle_error(
                        __("An error occured while performing the task", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                }
            break;
            /**
             * do=_thread_mark_all_read
             * Mark all thread as read
             */
            case mdh_current_plugin_name() . "_thread_mark_all_read":

                try {

                    $params = array();
                    $params["user"] = $this->user;
                    $params["unread"] = true;

                    // Find all the thread having unread messages.
                    $threads = $this->threads->findAll($params);

                    foreach ($threads as $thread) {
                        // User $user sets status $status to thread $id.
                        Madhouse_Messenger_Services_ThreadService::newInstance()->markAsRead($thread, $this->user);
                    }

                    // Redirects to the thread itself.
                    mdh_handle_ok(
                        sprintf(__("Successfully mark all threads as read", mdh_current_plugin_name())),
                        osc_get_http_referer()
                    );
                    $this->redirectTo(osc_get_http_referer());
                } catch(Madhouse_AuthorizationException $e) {
                    mdh_handle_error(
                        __("Nice try, but you can't do that!", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                } catch(Madhouse_QueryFailedException $e) {
                    mdh_handle_error(
                        __("An error occured while performing the task", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                } catch(Madhouse_NoResultsException $e) {

                }
            break;
            // DEFAULT
            default:
                // Don't know what to do. Pretend not to exist.
                Madhouse_Utils_Controllers::handleError();
            break;
        }
    }

    public static function findThread($threadId)
    {
        // Get the thread, throws exception and redirect if it does not exist.
        try {
            return Madhouse_Messenger_Models_Threads::newInstance()->findByPrimaryKey($threadId);
        } catch(Exception $e) {
            mdh_handle_error(
                __("The requested message or conversation does not exist", mdh_current_plugin_name()),
                mdh_messenger_inbox_url()
            );
        }
    }

    public static function findMessage($messageId)
    {
        try {
            return Madhouse_Messenger_Models_Messages::newInstance()->findByPrimaryKey($messageId);
        } catch (Exception $e) {
            mdh_handle_error(
                __("The requested message or conversation does not exist", mdh_current_plugin_name()),
                mdh_messenger_inbox_url()
            );
        }
    }

    public static function findStatus($statusId)
    {
        try {
            return Madhouse_Messenger_Models_Status::newInstance()->findByPrimaryKey($statusId);
        } catch(Exception $e) {
            mdh_handle_error(
                __("The requested status does not exist", mdh_current_plugin_name()),
                mdh_messenger_inbox_url()
            );
        }
    }

    public static function findLabel($labelId)
    {
        try {
            return Madhouse_Messenger_Models_Labels::newInstance()->findByPrimaryKey($labelId);
        } catch(Exception $e) {
            mdh_handle_error(
                __("The requested label does not exist", mdh_current_plugin_name()),
                mdh_messenger_inbox_url()
            );
        }
    }

    public function getResources()
    {
        // Sanitize array.
        $files = new FileBag($_FILES);

        $attachment = $files->get("attachment");

        if (!is_array($attachment)) {
            return array($attachment);
        }

        return $attachment;
    }
}
