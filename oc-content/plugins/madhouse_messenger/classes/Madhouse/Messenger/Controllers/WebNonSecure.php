<?php

use Madhouse\HttpFoundation\FileBag;
use Madhouse\HttpFoundation\File\Exception\FileException;

class Madhouse_Messenger_Controllers_WebNonSecure extends BaseModel {

    private $dao;
    private $user;

    /**
     * Current user making the request.
     *
     * @var Madhouse_User
     */
    protected $currentUser;

    /**
     * Current referer.
     *
     * @var string
     */
    //protected $refererUrl;

    /**
     * {@inheritdoc}
     */
    public function __construct() {
        parent::__construct();

        $this->settings = Madhouse_Messenger_Services_SettingsService::newInstance();
        $this->threads = Madhouse_Messenger_Services_ThreadService::newInstance();
        $this->messages = Madhouse_Messenger_Services_MessageService::newInstance();
        $this->resources = Madhouse_Messenger_Services_ResourceUploader::newInstance();
        $this->workflow = Madhouse_Messenger_Services_MessengerService::newInstance();
    }

    /**
     * Returns if the current user is logged in or not.
     *
     * @return boolean
     *
     * @see WebSecBaseModel::isLogged()
     */
    public function isLogged()
    {
        return osc_is_web_user_logged_in();
    }

    /**
     * Get the current user.
     *
     * @param  array  $users
     * @param  string $userEmail
     *
     * @return Madhouse_User
     */
    public function getCurrentUser($thread, $userSecret, $userEmail = null)
    {
        if ($this->currentUser) {
            // Return already existing current user.
            return $this->currentUser;
        }

        if ($this->isLogged()) {
            // Fetch & return registered user.
            $this->currentUser = Madhouse_Utils_Models::findUserByPrimaryKey(osc_logged_user_id());
            return $this->currentUser;
        }

        // Look into given $users list for $userEmail.
        foreach ($thread->getUsers() as $threadUser) {
            if ($userEmail == $threadUser->getEmail() && $threadUser->isRegistered()) {
                throw new Madhouse_Messenger_ForbiddenOperationException(
                    "User already registered",
                    1
                );
            } elseif ($userEmail == $threadUser->getEmail()) {

                if ($thread->getSecret() !== $userSecret) {
                    // Supplied secret token is not valid.
                    throw new Exception();
                }

                // Return the non-registered users.
                $this->currentUser = $threadUser;
                return $this->currentUser;
            }
        }

        // @TODO throw meaningful exception.
        throw new Exception(); // Return null instead ?
    }

    /**
     * Get the fallback URL where to redirect a user in case of an error.
     *
     * Non-registered users do not have access to inbox, they will have to be
     * redirected to the homepage instead.
     *
     * @return string
     */
    public function getFallbackUrl()
    {
        if ($this->isLogged()) {
            // User is logged in, let's redirect him to
            return mdh_messenger_inbox_url();
        }

        return osc_base_url();
    }

    /**
     * [showThreadAction]
     *
     * @param  int $threadId [description]
     * @param  string $secret   [description]
     * @param  string $email    [description]
     *
     * @return void
     */
    public function showThreadAction($threadId, $secret = "", $userEmail = "")
    {
        // Page number.
        $iDisplayPage = Params::getParam("p");
        if(!isset($iDisplayPage) || empty($iDisplayPage)) {
            $iDisplayPage = 1;
            Params::setParam("p", $iDisplayPage);
        }

        // Number of messages displayed per page.
        $iDisplayLength = Params::getParam("n");
        if(!isset($iDisplayLength) || empty($iDisplayLength)) {
            $iDisplayLength = 10;
            Params::setParam("n", $iDisplayLength);
        }

        // Get the thread id from the request.
        $threadId = Params::getParam("id");

        // Find the thread.
        $thread = null;
        $currentUser = null;
        try {
            // Find the thread.
            $thread = $this->threads->findThreadById($threadId);

            // Get the current user.
            $currentUser = $this->getCurrentUser($thread, $secret, $userEmail);

        } catch (Madhouse_Messenger_ForbiddenOperationException $e) {
            if ($e->getCode() == 1) {
                mdh_handle_warning(
                    __("You are registered. Please login to see the thread.", mdh_current_plugin_name()),
                    osc_user_login_url()
                );
            }
        } catch (Exception $e) {
            // Pretend it does not exist.
            mdh_handle_error(
                __("The requested message or conversation does not exist", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        }

        try {
            // Mark messages as read.
            $this->threads->markAsRead($thread, $currentUser);
        } catch (Madhouse_AuthorizationException $e) {
            // Pretend it does not exist.
            mdh_handle_error(
                __("The requested message or conversation does not exist", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        } catch (Exception $e) {
            mdh_handle_error(
                __("An error occured while performing the task", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        }

        // Extend thread with messages and resources.
        $threadMessages = array();
        $threadResources = array();
        try {
            // Get thread messages.
            $threadMessages = $this->messages->findAll(
                array(
                    "thread" => $thread,
                    "user" => $currentUser
                ),
                array(
                    "iDisplayPage" => $iDisplayPage,
                    "iDisplayLength" => $iDisplayLength,
                )
            );

            // Get the thread resources (all of them).
            $threadResources = $this->resources->findAll(
                array(
                    "thread" => $thread->getId(),
                )
            );
        } catch (Exception $e) {
            mdh_handle_error(
                __("An error occured while performing the task", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        }

        // Create a view object.
        $threadView = new Madhouse_Messenger_Views_ThreadSummary(
            $currentUser,
            $thread,
            0 // We've just marked the thread as read.
        );
        $messageViews = array_map(
            function($m) use ($currentUser) {
                return new Madhouse_Messenger_Views_Message($currentUser, $m);
            },
            $threadMessages
        );

        // Set blocked users if current user exists in database.
        if ($currentUser->isShim() === false) {
            $threadView->setBlockedUsers(Madhouse_Messenger_Models_BlockedUsers::newInstance()->findByUserAndThread($currentUser, $threadView));
        }

        // Load and send view object to the view.
        $this->_exportVariableToView("mdh_viewer", $currentUser);
        $this->_exportVariableToView("mdh_thread", $threadView);
        $this->_exportVariableToView("mdh_thread_resources", $threadResources);
        $this->_exportVariableToView("mdh_messages", $messageViews);
        $this->_exportVariableToView("mdh_statuss", Madhouse_Messenger_Models_Status::newInstance()->findAll());
        if ($this->isLogged()) {
            $this->_exportVariableToView("user", User::newInstance()->findByPrimaryKey(osc_logged_user_id()));
        }

        // Export all the other extra-datas related to this thread.
        Madhouse_Messenger_ThreadActions::extendExport();

        osc_remove_script("fancybox");
        osc_remove_style("fancybox");


        osc_add_filter('meta_title_filter', function ($text) use ($threadView) {
            if (!$threadView->isGroup()) {
                if ($threadView->hasItem()) {
                    return sprintf(__("Talking with %s - %s", mdh_current_plugin_name()), $threadView->getOther()->getName(), $threadView->getItem()->getTitle());
                } else {
                    return sprintf(__("Talking with %s", mdh_current_plugin_name()), $threadView->getOther()->getName());
                }
            }
            return $text;
        });

        // Run a hook when showing a thread.
        osc_run_hook("mdh_show_thread");
    }

    /**
     * [updateStatusAction]
     *
     * @param  int $threadId.
     * @param  int $statusId.
     * @param  string $secret.
     * @param  string $userEmail.
     *
     * @return void.
     */
    public function updateStatusAction($threadId, $statusId, $secret = "", $userEmail = "")
    {
        $thread = null;
        $currentUser = null;
        $newStatus = null;
        try {
            // Find the thread.
            $thread = $this->threads->findThreadById($threadId);

            // Find the new status to apply.
            $newStatus = self::findStatus($statusId);

            // Get the current user.
            $currentUser = $this->getCurrentUser($thread, $secret, $userEmail);

        } catch (Exception $e) {
            // Pretend it does not exist.
            mdh_handle_error(
                __("The requested message or conversation does not exist", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        }

        try {
            // User $user sets status $status to thread $id.
            $this->workflow->applyStatus(
                $thread,
                $newStatus,
                $currentUser
            );

        } catch(Madhouse_AuthorizationException $e) {
            mdh_handle_error(
                __("Nice try, but you can't do that!", mdh_current_plugin_name()),
                osc_base_url()
            );
        } catch(Madhouse_Messenger_NoValidRecipientsException $e) {
            mdh_handle_error(
                __("Sorry, you can't send a message to a disabled/deleted user", mdh_current_plugin_name()),
                mdh_messenger_thread_url($thread->getId(), $secret, $userEmail)
            );
        } catch(Madhouse_QueryFailedException $e) {
            mdh_handle_error(
                __("An error occured while performing the task", mdh_current_plugin_name()),
                osc_base_url()
            );
        }
        mdh_handle_ok(
            __("We've successfully updated the thread status",
            mdh_current_plugin_name()),
            mdh_messenger_thread_url($thread->getId(), $secret, $userEmail)
        );
    }

    /**
     * [updateTitleAction]
     *
     * @param  int $threadId.
     * @param  int $statusId.
     * @param  string $secret.
     * @param  string $userEmail.
     *
     * @return void.
     */
    public function updateTitleAction($threadId, $title, $secret = "", $userEmail = "")
    {
        $thread = null;
        $currentUser = null;
        $newTitle = null;
        try {
            // Find the thread.
            $thread = $this->threads->findThreadById($threadId);

            $thread->setTitle($title);

            // Get the current user.
            $currentUser = $this->getCurrentUser($thread, $secret, $userEmail);

        } catch (Exception $e) {
            // Pretend it does not exist.
            mdh_handle_error(
                __("The requested message or conversation does not exist", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        }

        try {
            // User $user sets status $status to thread $id.
            $this->threads->updateThread(
                $thread
            );

        } catch(Madhouse_AuthorizationException $e) {
            mdh_handle_error(
                __("Nice try, but you can't do that!", mdh_current_plugin_name()),
                osc_base_url()
            );
        } catch(Madhouse_Messenger_NoValidRecipientsException $e) {
            mdh_handle_error(
                __("Sorry, you can't send a message to a disabled/deleted user", mdh_current_plugin_name()),
                mdh_messenger_thread_url($thread->getId(), $secret, $userEmail)
            );
        } catch(Madhouse_QueryFailedException $e) {
            mdh_handle_error(
                __("An error occured while performing the task", mdh_current_plugin_name()),
                osc_base_url()
            );
        }
        mdh_handle_ok(
            __("We've successfully updated the thread title",
            mdh_current_plugin_name()),
            mdh_messenger_thread_url($thread->getId(), $secret, $userEmail)
        );
    }

    /**
     * [deleteMessageAction]
     *
     * @param  int $messageId
     * @param  string $secret
     * @param  string $email
     *
     * @return void
     */
    public function deleteMessageAction($messageId, $secret = "", $email = "")
    {
        // Find the requested message.
        try {
            $message = $this->messages->findMessageById($messageId);

            $thread = $this->threads->findThreadById($message->getThread()->getId());
        } catch (Exception $e) {
            mdh_handle_error(
                __("The requested message or conversation does not exist", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        }

        $currentUser = null;
        try {
            // Find the user.
            $currentUser = $this->getCurrentUser($thread, $secret, $email);
        } catch (Exception $e) {
            /**
             * Not logged, no secret or email, not authorized to do this.
             * Pretend the page does not exists.
             */
            mdh_handle_error(
                __("The requested message or conversation does not exist", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        }

        $message = new Madhouse_Messenger_Views_Message($currentUser, $message);

        // Actually delete the message.
        try {
            $this->messages->deleteMessage($message, $currentUser);
        } catch (Madhouse_Messenger_ForbiddenOperationException $e) {
            // Pretend it does not exist.
            mdh_handle_error(
                __("You can not delete this message", mdh_current_plugin_name()),
                mdh_messenger_thread_url($thread->getId(), $secret, $email)
            );
        } catch (Madhouse_AuthorizationException $e) {
            // Pretend it does not exist.
            mdh_handle_error(
                __("The requested message or conversation does not exist", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        } catch (Exception $e) {
            mdh_handle_error(
                __("An error occured while performing the task", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        }

        // Redirect to thread.
        mdh_handle_ok(
            __("Message deleted", mdh_current_plugin_name()),
            mdh_messenger_thread_url($message->getThread()->getId(), $secret, $email)
        );
    }

    public function sendAction($secret = "", $userEmail = "")
    {
        osc_csrf_check();

        $threadId = Params::getParam("tid");

        Session::newInstance()->_setForm("pp_yourName", Params::getParam("yourName"));
        Session::newInstance()->_setForm("pp_yourEmail", Params::getParam("yourEmail"));
        Session::newInstance()->_setForm("pp_message", Params::getParam("message", false, false));
        Session::newInstance()->_setForm("pp_subject", Params::getParam("subject"));
        Session::newInstance()->_keepForm('pp_yourName');
        Session::newInstance()->_keepForm('pp_yourMail');
        Session::newInstance()->_keepForm('pp_message');
        Session::newInstance()->_keepForm('pp_subject');

        /*
         * Sent from the thread itself.
         *     Reply to thread & redirect to the thread.
         */
        try {
            if(isset($threadId) && !empty($threadId)) {
                // Getting thread from database.
                $thread = $this->threads->findThreadById($threadId);

                // Redirect to the thread.
                $to = mdh_messenger_thread_url($thread->getId(), $secret, $userEmail);

                // Get the current user.
                $currentUser = $this->getCurrentUser($thread, $secret, $userEmail);

                // Filter recipients from thread.
                $recipients = $this->messages->filterRecipients($currentUser, $thread->getUsers());

                $newMessage = new Madhouse_Messenger_Message(
                    Params::getParam("message", false, false),
                    $currentUser,
                    $recipients
                );

                // Set the thread to the candidate message.
                $newMessage->setThread($thread);

                // Reply to the thread.
                $this->workflow->reply($thread, $newMessage, $this->getUploadedFiles());
            } else {
                /*
                 * Sent from item contact form (without thread id).
                 *     EITHER; create a new thread;
                 *     OR; reply to an existing thread (between the two users and for this item)
                 */
                if ($this->isLogged()) {
                    $currentUser = Madhouse_Utils_Models::findUserByPrimaryKey(osc_logged_user_id());
                } else {
                    $currentUser = new Madhouse_User(
                        array(
                            "s_email" => $userEmail,
                            "s_name"  => Params::getParam("yourName")
                        )
                    );
                }

                // Init recipients.
                $recipients = array();
                $item = null;

                /*
                 * Legacy mode, contact from the messenger contact-form.php.
                 */
                if (osc_item() === "" && osc_user() === "" && Params::existParam("id"))  {

                    // Find the item @ database.
                    $item = Item::newInstance()->findByPrimaryKey(Params::getParam("id"));
                    if ($item == false) {
                        // Item not found or not valid.
                        throw new Madhouse_Messenger_NoValidRecipientsException();
                    }

                    // Export variable to view.
                    $this->_exportVariableToView("item", $item);
                }

                // Get itemId or userId
                if (osc_item_id()) {
                    /*
                     * Being forwarded from item&contact_post (via hook).
                     */
                    $item = osc_item();

                    // Set redirection url to item page.
                    $to = osc_item_url();

                    // Find recipient(s) from item.
                    if (osc_item_user_id()) {
                        /*
                         * Item's owner is a registered user, find him.
                         */
                        $recipients[] = Madhouse_Utils_Models::findUserByPrimaryKey(osc_item_user_id());
                    } elseif (!osc_item_user_id()) {
                        /*
                         * Item's owner is NOT a registered user, create a shim
                         * user object for him.
                         */
                        $recipients[] = new Madhouse_User(
                            array(
                                "s_name" => osc_item_contact_name(),
                                "s_email" => osc_item_contact_email(),
                            )
                        );
                    }
                } elseif (osc_user_id()) {
                    /*
                     * Being forwarded from user&contact_post (via hook).
                     */

                    // Add recipient to current recipients array.
                    $recipients[] = new Madhouse_User(osc_user());

                    // Set redirection url to item page.
                    $to = osc_user_public_profile_url(osc_user_id());
                } else {
                    // Fail, can't say where you come from.
                    throw new Madhouse_Messenger_OperationFailedException();
                }

                // If recipients[] exists, merge with the current recipients.
                if (Params::existParam("recipients")) {
                    $recipients = array_merge(
                        $recipients,
                        Madhouse_Utils_Models::findUsersByPrimaryKey(Params::getParam("recipients"))
                    );
                }

                // Filter recipients from thread.
                $recipients = $this->messages->filterRecipients($currentUser, $recipients);

                // Get content from form.
                $content = Params::getParam("message", false, false);

                // Create the message object.
                $message = new Madhouse_Messenger_Message($content, $currentUser, $recipients);

                // Contact the item/user.
                $this->workflow->contact(
                    $message,
                    $this->getUploadedFiles(),
                    $item,
                    Params::getParam("subject")
                );
            }

        } catch (Madhouse_AuthorizationException $e) {
            mdh_handle_error(
                __("Nice try, but you can't do that!", mdh_current_plugin_name()),
                osc_base_url()
            );
        } catch (Madhouse_NoResultsException $e) {
            mdh_handle_error(
                __("The requested message or conversation does not exist", mdh_current_plugin_name()),
                osc_base_url()
            );
        } catch (Madhouse_Messenger_EmptyMessageException $e) {
            mdh_handle_error(
                __("Can't send an empty message", mdh_current_plugin_name()),
                $to
            );
        } catch (Madhouse_Messenger_NoValidRecipientsException $e) {
            mdh_handle_error(
                __("Sorry, you can't send a message to a disabled/deleted user", mdh_current_plugin_name()),
                $to
            );
        } catch (Madhouse_NoValidItemException $e) {
            mdh_handle_error(
                __("Sorry, you can't send a message to a disabled/deleted item", mdh_current_plugin_name()),
                $to
            );
        } catch (Madhouse_Messenger_ForbiddenOperationException $e) {
            if ($e->getCode() == 1) {
                mdh_handle_warning(
                    __("This email is already registered. Please login to send a message.", mdh_current_plugin_name()),
                    osc_user_login_url()
                );
            } elseif ($e->getCode() == 2) {
                mdh_handle_error(
                    __("Sorry, you can't send a message to this user. He may have blocked you.", mdh_current_plugin_name()),
                    $to
                );
            } elseif ($e->getCode() == 4) {
               mdh_handle_error(
                    __("Your name and/or email address do not seem valid.", mdh_current_plugin_name()),
                    $to
                );
            } else {
                mdh_handle_error(
                    __("An error occured while performing the task", mdh_current_plugin_name()),
                    $to
                );
            }
        } catch (FileException $e) {
            mdh_handle_error(
                __("Failed to send the message. One of your files is too big or isn't an allowed extension.", mdh_current_plugin_name()),
                $to
            );
        } catch (Exception $e) {
            mdh_handle_error(
                __("An error occured while performing the task", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        }

        // Drop form info when the message is sent!
        Session::newInstance()->_dropKeepForm('pp_yourName');
        Session::newInstance()->_dropKeepForm('pp_yourMail');
        Session::newInstance()->_dropKeepForm('pp_message');
        Session::newInstance()->_dropKeepForm('pp_subject');
        Session::newInstance()->_clearVariables();

        // All is fine, just redirect to the $to page.
        mdh_handle_ok(__("We've successfully sent your message", mdh_current_plugin_name()), $to);
    }

    /**
     * Business control for Madhouse Messenger Plugin for OSClass.
     */
    public function doModel() {
        // Catch post_max_size error!
        // http://andrewcurioso.com/blog/archive/2010/detecting-file-size-overflow-in-php.html
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) && empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0) {
            mdh_handle_error(
                __("Posted data exceeds the server limit. Probable cause: uploaded file is too large.", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        }

        $secret = (Params::getParam("secret") != "") ? Params::getParam("secret") : null;
        $userEmail = null;
        if (Params::existParam("yourEmail")) {
            $userEmail = (Params::getParam("yourEmail") != "") ? Params::getParam("yourEmail") : null;
        } elseif (Params::existParam("email")) {
            $userEmail = (Params::getParam("email") != "") ? Params::getParam("email") : null;
        }

        /*
         * Check login or secret / identity and redirect if necessary.
         */
        if (!$this->isLogged()
            && Params::getParam("route") !== mdh_current_plugin_name() . "_send"
            && ($secret === null || $userEmail === null)
        ) {
            // Handling referers for inbox and thread page.
            if(!osc_get_http_referer()) {
                Session::newInstance()->_setReferer(mdh_messenger_thread_url(Params::getParam("id")));
            }

            osc_add_flash_info_message(__("Please login to access to your messages", mdh_current_plugin_name()));
            $this->redirectTo(osc_user_login_url());
            exit;
        }

        switch(Params::getParam("route")) {
            case mdh_current_plugin_name() . "_message_delete":
                $this->deleteMessageAction(Params::getParam("id"), $secret, $userEmail);
            break;
            // MESSAGE
            case mdh_current_plugin_name() . "_thread_non_secure":
                if ($this->isLogged()) {
                    $this->redirectTo(mdh_messenger_thread_url(Params::getParam("id")));
                }
            case mdh_current_plugin_name() . "_thread":
                $this->showThreadAction(Params::getParam("id"), $secret, $userEmail);
            break;
            // SEND
            case mdh_current_plugin_name() . "_send":
                $this->sendAction($secret, $userEmail);
            break;
            // STATUS_CHANGE
            case mdh_current_plugin_name() . "_thread_status":
                $this->updateStatusAction(Params::getParam("id"), Params::getParam("status"), $secret, $userEmail);
            break;
            case mdh_current_plugin_name() . "_thread_title":
                $this->updateTitleAction(Params::getParam("tid"), Params::getParam("subject"), $secret, $userEmail);
            break;
            // DEFAULT
            default:
                // Don't know what to do. Pretend not to exist.
                Madhouse_Utils_Controllers::handleError();
            break;
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

    public function getUploadedFiles()
    {
        if (!$this->settings->isAttachementEnabled()) {
            // Just ignore the files.
            return array();
        }

        // Sanitize array.
        $files = new FileBag($_FILES);

        // Get attachement parameter.
        $uploadedFiles = $files->get("attachment");
        if (!is_array($uploadedFiles)) {
            // Only one attachment, not attachement[], wrapped in an array.
            $uploadedFiles = array($uploadedFiles);
        }

        return $uploadedFiles;
    }

    function doView($file)
    {
        // DO NOTHING
    }
}
