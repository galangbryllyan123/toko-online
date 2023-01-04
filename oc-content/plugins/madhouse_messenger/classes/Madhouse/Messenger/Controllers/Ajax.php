<?php

class Madhouse_Messenger_Controllers_Ajax extends BaseModel
{
    /**
     * Current user.
     *
     * @var Madhouse_User
     */
    protected $user;

    function __construct()
    {
        parent::__construct();
        $this->ajax = true;

        // DAOs.
        $this->threadsDAO = Madhouse_Messenger_Models_Threads::newInstance();
        $this->messagesDAO = Madhouse_Messenger_Models_Messages::newInstance();

        // Services.
        $this->threads = Madhouse_Messenger_Services_ThreadService::newInstance();
        $this->messages = Madhouse_Messenger_Services_MessageService::newInstance();
        $this->resources = Madhouse_Messenger_Services_ResourceUploader::newInstance();

        // Create a Madhouse_User object for the logged user.
        if (osc_is_web_user_logged_in()) {
            $this->loggedUser = Madhouse_Utils_Models::findUserByPrimaryKey(osc_logged_user_id());
        }
    }

    function doModel()
    {
        $secret = Params::getParam("secret");
        $userEmail = Params::getParam("email");

        /*
         * Serve raw resource to the browser.
         *
         * It hides the actual path on the server which is good for security reasons
         * and serve the content to the browser, force the download if not readable
         * by the browser (eg. image).
         *
         */
        if (Params::getParam("route") === mdh_current_plugin_name() . "_resources_raw") {
            $secret = Params::getParam("secret");
            $format = Params::existParam("format") ? Params::getParam("format") : null;

            try {
                // Try and find the resource.
                $resource = $this->resources->findResourceBySecret($secret);

                // Tell the browser it will receive raw content.
                header("Content-Type: " . $resource->getMimeType());
                header("Content-Length: " . filesize($resource->getRealPath($format)));

                // All files are downloaded except images.
                if (!$resource->isImage()) {
                    header("Content-Disposition: attachment; filename=" . $resource->getOriginalName());
                }

                // Actually serve the file "as is", eg. raw. If not readable by the browser, it will be downloaded.
                readfile($resource->getRealPath($format));
            } catch (Exception $e) {
                // All case will trigger a 404 error.
                header('X-PHP-Response-Code: 404', true, 404);
                // @see http://stackoverflow.com/questions/3258634/php-how-to-send-http-response-code
            }
        } else {
            header('Content-Type: application/json');

            switch (Params::getParam("do")) {
                /**
                 * do=more
                 * Load {n} previous messages in the thread.
                 *    It returns a list of seralized messages as JSON string.
                 *    Takes thread {id} and optional page {p} and number {n} to paginate.
                 */
                case "more":

    				$error = false;
                    // Thread requested.
                    $threadId = Params::getParam("tid");

                    if (empty($threadId) || !is_numeric($threadId)) {
                        $error = true;
                        $text = __("The requested message / conversation does not exists.", mdh_current_plugin_name());
                    }

                    if (!$error) {
                        // Page number.
        				$p = Params::getParam("p");
        				// Number of messages per page.
        				$n = Params::getParam("n");
        				if(!isset($n) || empty($n)) {
        				    $n = 10;
        				}

                        try {
                            $thread = $this->threadsDAO->findByPrimaryKey($threadId);
                        } catch (Madhouse_AuthorizationException $e) {
                            $error = true;
                            $text = __("The requested message / conversation does not exists.", mdh_current_plugin_name());
                        } catch (Madhouse_QueryFailedException $e) {
                            $error = true;
                            $text = __("An error occured while performing the task.", mdh_current_plugin_name());
                        } catch (Exception $e) {
                            $error = true;
                            $text = __("An error occured while performing the task.", mdh_current_plugin_name());
                        }

                        // Get the current user.
                        $threadUsers = $thread->getUsers();
                        foreach ($threadUsers as $threadUser) {
                            if (osc_is_web_user_logged_in() && osc_logged_user_id() === $threadUser->getId()) {
                                $this->user = Madhouse_Utils_Models::findUserByPrimaryKey(osc_logged_user_id());
                                break;
                            } elseif (!empty($userEmail) && $userEmail === $threadUser->getEmail()) {
                                $this->user = $threadUser;
                                break;
                            }
                        }
                        if ($this->user === null) {
                            $error = true;
                            $text = __("The requested message / conversation does not exists.", mdh_current_plugin_name());
                        }
                    }

                    if ($error) {
                        echo json_encode(
                            array(
                                "error" => $error,
                                "reason" => $text
                            )
                        );
                        break;
                    }

                    // For array_map.
                    $viewer = $this->user;

    				// Returns a JSON encoded array of all the messages.
    				echo json_encode(array(
    					"data" => array_map(
    					    function($m) use($viewer, $secret, $userEmail) {
    					        $mv = new Madhouse_Messenger_Views_Message(
    					            $viewer,
    					            $m
    					        );
    					        $messageAsArray = $mv->toArray();

                                return $messageAsArray;
    					    },
    					    $this->messagesDAO->findByThread($thread, $p, $n)
    					),
    					"hasMore" => $thread->hasMoreMessages($p, $n)
    				));
    			break;
                /**
                 * do=widget
                 * List the last 5 threads in which the logged user belongs to.
                 * 		It returns this list serialized as a JSON string.
                 * 		Takes no parameters at all, just using osc_logged_user_id().
                 */
                case "widget":
                    if (!osc_is_web_user_logged_in()) {
                        echo json_encode(array('error' => __("Please login to access to your messages", mdh_current_plugin_name())));
                        exit;
                    }

                    // Get the current logged user.
                    $user = $this->loggedUser;

                    try {
                        // Get all threads in inbox.
                        $threads = $this->threads->findAll(
                            array(
                                "user" => $user,
                                "label" => "inbox",
                            ),
                            array(
                                "iDisplayPage" => 1,
                                "iDisplayLength" => 5
                            )
                        );

                        // Get count of unread messages.
                        if (count($threads) > 0) {
                            $inbox = Madhouse_Messenger_Models_Labels::newInstance()->findByName("inbox");

                            $countUnread = $this->messages->countAll(
                                array(
                                    "user" => $user,
                                    "label" => $inbox,
                                    "received" => true,
                                    "unread" => true,
                                )
                            );
                        } else {
                            $countUnread = 0;
                        }

                        // Return formatted response.
                        echo json_encode(array(
                            "threads" => array_map(
                                function ($thread) {
                                    // Map to array.
                                    return $thread->toArray();
                                },
                                $threads
                            ),
                            "nbUnread" => $countUnread

                        ));
                    } catch(Madhouse_QueryFailedException $e) {
                        echo json_encode(array(
                            "error" => __("Something went wrong performing the task!", mdh_current_plugin_name())
                        ));
                    }
                break;
                default:
                    echo json_encode(array('error' => __('No action defined', mdh_current_plugin_name())));
                break;
            }
        }
    }

    function doView($file)
    {
        // DO NOTHING
    }

}

?>
