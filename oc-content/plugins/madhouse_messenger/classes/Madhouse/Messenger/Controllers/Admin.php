<?php

class Madhouse_Messenger_Controllers_Admin extends AdminSecBaseModel
{
	public function __construct() {
		parent::__construct();
		$this->ajax = true;

		// Inits DAO objects.
		$this->statusDAO = Madhouse_Messenger_Models_Status::newInstance();
		$this->messagesDAO = Madhouse_Messenger_Models_Messages::newInstance();
        $this->messageService = Madhouse_Messenger_Services_MessageService::newInstance();
		$this->threadsDAO = Madhouse_Messenger_Models_Threads::newInstance();
        $this->blockedUserDAO = Madhouse_Messenger_Models_BlockedUsers::newInstance();

        $this->resources = Madhouse_Messenger_Services_ResourceUploader::newInstance();
        $this->settings = Madhouse_Messenger_Services_SettingsService::newInstance();
        $this->workflow = Madhouse_Messenger_Services_MessengerService::newInstance();

        $this->labels = Madhouse_Messenger_Services_LabelService::newInstance();
	}

    public function getFallbackUrl()
    {
        // @TODO referer?
        return mdh_messenger_admin_dashboard_url();
    }

	/**
	 * Loads the dashboard view.
	 * @since 1.12
	 */
	private function doDashboard()
	{
	    // Exports stats for the dashboard.
	    $this->_exportVariableToView("messages_count", $this->messagesDAO->count());
	    $this->_exportVariableToView("threads_count", $this->threadsDAO->count());

        if (Params::getParam('type') == "month") {
            $filter = 'month';
            $threadsCount      = $this->threadsDAO->countThisMonth();
            $messagesCount     =  $this->messagesDAO->countThisMonth();
            $threadLastCount   =  $this->threadsDAO->countLastMonth();
            $messagesLastCount = $this->messagesDAO->countLastMonth();
        } elseif (Params::getParam('type') == "week") {
            $filter = 'week';
            $threadsCount      = $this->threadsDAO->countThisWeek();
            $messagesCount     =  $this->messagesDAO->countThisWeek();
            $threadLastCount   =  $this->threadsDAO->countLastWeek();
            $messagesLastCount = $this->messagesDAO->countLastWeek();
        } else {
            Params::setParam('type', 'day');
            $filter = 'day';
            $threadsCount      = $this->threadsDAO->countToday();
            $messagesCount     =  $this->messagesDAO->countToday();
            $threadLastCount   =  $this->threadsDAO->countYesterday();
            $messagesLastCount = $this->messagesDAO->countYesterday();
        }

        if (Params::getParam('period') == "" || !is_numeric(Params::getParam('period'))) {
            Params::setParam('period', 10);
        }
        $period = Params::getParam('period');

        $this->_exportVariableToView("threads_count_current", $threadsCount);
        $this->_exportVariableToView("messages_count_current", $messagesCount);
        $this->_exportVariableToView("threads_count_last", $threadLastCount);
        $this->_exportVariableToView("messages_count_last", $messagesLastCount);


        $this->_exportVariableToView("charts_messages", $this->messageService->countByFormat($filter, $period));
        $this->_exportVariableToView("charts_threads", $this->messageService->countByFormat($filter, $period, array('thread' => true)));
        $this->_exportVariableToView("stats_users", $this->messageService->countBy($filter, $period, array('user' => true)));
        $this->_exportVariableToView("stats_items", $this->messageService->countBy($filter, $period, array('item' => true)));
	}

	/**
	 * Loads the "Manage Messages" view.
	 * @since 1.12
	 */
	private function doMessages()
	{
	    $iPage = Params::getParam("iPage");
        if(!isset($iPage) || empty($iPage)) {
            $iPage = 1;
            Params::setParam("iPage", $iPage);
        }

        $iDisplayLength = Params::getParam("iDisplayLength");
        if(!isset($iDisplayLength) || empty($iDisplayLength)) {
            $iDisplayLength = 50;
            Params::setParam("iDisplayLength", $iDisplayLength);
        }

        $filterType = Params::getParam("filter-type");
        $thread = Params::getParam("threadId");
        $user = Params::getParam("userId");
        $item = Params::getParam("itemId");
        if($filterType == "oThread" && isset($thread) && !empty($thread)) {
            $t = null;
            try {
                $t = $this->threadsDAO->findByPrimaryKey($thread);
            } catch(Exception $e) {
                mdh_handle_error(
                    __("The requested message / conversation does not exists.", mdh_current_plugin_name()),
                    mdh_messenger_admin_messages_url()
                );
            }

            osc_add_filter("custom_listing_title", function($s) use ($t) {
                return sprintf(__("Messages of '%s' (Thread: #%d)",
                    mdh_current_plugin_name()),
                    implode(", ", array_map(function($u) { return $u->getName(); }, $t->getUsers())),
                    $t->getId());
                }
            );

            $this->_exportVariableToView(
                "mdh_messages",
                $this->messagesDAO->findByThread($t, $iPage, $iDisplayLength)
            );
            $this->_exportVariableToView("count", $this->messagesDAO->countByThread($thread));

        } else if ($filterType == "oUser" && isset($user) && !empty($user)) {
            $u = null;
            try {
                if (filter_var($user, FILTER_VALIDATE_INT) === false) {
                    $u = new Madhouse_User(
                        array(
                            "s_name" => __("Non-registered users", mdh_current_plugin_name()),
                            "s_email" => $user,
                        )
                    );
                } else {
                    $u = Madhouse_Utils_Models::findUserByPrimaryKey($user);
                }

            } catch (Exception $exception) {
                mdh_handle_error(
                    __("The requested user does not exist.", mdh_current_plugin_name()),
                    mdh_messenger_admin_messages_url()
                );
            }

            if ($u->isDeleted()) {
                mdh_handle_error(
                    __("User is deleted, you can't filter on his messages.", mdh_current_plugin_name()),
                    mdh_messenger_admin_messages_url()
                );
            }

            osc_add_filter("custom_listing_title", function($s) use ($u) {
                return sprintf(
                    __("%s's messages (User: %s)", mdh_current_plugin_name()),
                    $u->getName(),
                    ($u->isRegistered()) ? "#" . $u->getId() : $u->getEmail()
                );
            });

            $this->_exportVariableToView("count", $this->messagesDAO->countByUser($u, array("sent" => true)));
            $this->_exportVariableToView(
                "mdh_messages",
                $this->messagesDAO->findByUser($u, array(), $iPage, $iDisplayLength)
            );
        } else if($filterType == "oItem" && isset($item) && !empty($item)) {
            $this->_exportVariableToView("count", $this->messagesDAO->countByItem($item));
            $this->_exportVariableToView(
                "mdh_messages",
                $this->messagesDAO->findByItem($item, $iPage, $iDisplayLength)
            );
        } else {
            $this->_exportVariableToView("count", $this->messagesDAO->count());
            $this->_exportVariableToView("mdh_messages", $this->messagesDAO->findAll($iPage, $iDisplayLength));
        }
	}

    /**
     * Loads the "Blocked Users" view.
     * @since 1.50
     */
    private function doBlockedUsers() {
        $iPage = Params::getParam("iPage");
        if(!isset($iPage) || empty($iPage)) {
            $iPage = 1;
            Params::setParam("iPage", $iPage);
        }

        $iDisplayLength = Params::getParam("iDisplayLength");
        if(!isset($iDisplayLength) || empty($iDisplayLength)) {
            $iDisplayLength = 50;
            Params::setParam("iDisplayLength", $iDisplayLength);
        }

        $filters = array();
        $this->_exportVariableToView("count", $this->blockedUserDAO->countAll($filters));
        $this->_exportVariableToView("mdh_blocked_users", $this->blockedUserDAO->findAll($filters, $iPage, $iDisplayLength));
    }

    /**
     * Unblock a user for a user.
     * @since 1.50
     */
    private function doUnblockedUser() {
        // Getting user1 from database (always registered).
        $user = Madhouse_Utils_Models::findUserByPrimaryKey(Params::getParam("userId"));

        // Get the blocked user to unblock.
        $blockedUserId = Params::getParam("blockedUserId");
        if (filter_var($blockedUserId, FILTER_VALIDATE_INT) === false) {
            $userBlocked = new Madhouse_User(
                array(
                    "s_name" => __("Blocked User", "madhouse_messenger"),
                    "s_email" => $blockedUserId,
                )
            );
        } else {
            $userBlocked = Madhouse_Utils_Models::findUserByPrimaryKey($blockedUserId);
        }


        try {
            // User $user sets status $status to thread $id.
            $unblockedUser = Madhouse_Messenger_Models_BlockedUsers::newInstance()->removeBlockedUser($user, $userBlocked);

            // Redirects to the thread itself.
            mdh_handle_ok(
                sprintf(__("Successfully unblocked user %s for %s", mdh_current_plugin_name()), $userBlocked->getName(), $user->getName()),
                osc_get_http_referer()
            );
            $this->redirectTo(osc_get_http_referer());
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
    }

	/**
	 * Load the settings view.
	 * @since 1.12
	 */
	private function doSettings()
	{


	    $this->_exportVariableToView("statuses", $this->statusDAO->findAll());
	    $this->_exportVariableToView("user",
	        User::newInstance()->findByPrimaryKey(
	            osc_get_preference('moderation_user', mdh_current_preferences_section())
	        )
	    );

        if (!$this->resources->hasMimeTypeGuesser()) {
            $this->_exportVariableToView("resources_mimetype_warning", true);
        }

        $extensionWhiteList = $this->settings->getResourceExtensionList();
        foreach ($extensionWhiteList as $extension) {
            $x = $this->resources->isExtensionSupported($extension);
            if ($x === false) {
                // Warn the admin that an extension is not supported.
                osc_add_flash_warning_message(
                    sprintf(__("'%s' does not match any known extension/type", mdh_current_plugin_name()), $extension),
                    "admin"
                );
            }
        }

        if (file_exists($this->resources->getBasePath() . "/.htaccess")) {
            $this->_exportVariableToView("resources_htaccess_content", file_get_contents($this->resources->getBasePath() . "/.htaccess"));
        } else {
            $this->_exportVariableToView("resources_htaccess_content", file_get_contents(mdh_current_plugin_path("assets/htaccess-sample.conf", false)));
        }
	}

	/**
	 * Save the settings and redirect to settings view.
	 * @since 1.12
	 */
	private function doSettingsPost()
	{
        $reminderEvery = Params::getParam("reminder_every");
        if($reminderEvery <= 1) {
            // Illegal value for reminder_every.
            mdh_handle_error(
                sprintf(__("Can't send reminder every '%s' new messages. Must be greater than 1.", mdh_current_plugin_name()), $reminderEvery),
                mdh_messenger_admin_settings_url()
            );
        }

        $this->resources->setupFilesystem(
            true,
            Params::getParam("resources_htaccess_content", false, false)
        );

        Madhouse_Utils_Controllers::doSettingsPost(
            array(
                "display_usermenu_link",
                "subject_enabled",
                "subject_edit_enabled",
                "delete_mode",
                "moderation_user",
                "automessage_item_deleted",
                "automessage_item_spammed",
                "automessage_newer_days",
                "base_url",
                "enable_notifications",
                "email_excerpt_length",
                "email_excerpt_oneline",
                "notify_everytime",
                "stop_notify_after",
                "enable_reminders",
                "reminder_every",
                "reminder_every_days",
                "stop_reminder_after",
                "resources_secure_url",
                "resources_extensions_whitelist",
                "resources_max_size_kb",
                "resources_thumbnail_size",
                "resources_max_per_message",
                "enable_status",
                "default_status",
                "status_for_owner_only",
                "enable_message_template",
                "enable_block_user",
                "email_admin_on_block_user",
                "enable_mark_as_unread",
                "enable_mark_all_as_read",
                "enable_autolinker",
                "autolinker_new_window",
                "autolinker_strip_prefix",
                "autolinker_truncate_length"
            ),
            Params::getParamsAsArray("post"),
            mdh_messenger_admin_settings_url()
        );
	}

	/**
	 * Blocks/Unblocks a message (for spam) and redirect to manage messages view.
	 * @since 1.12
	 */
	private function doBlock($block=true)
	{
        $messagesId = Params::getParam("id");
        if(!empty($messagesId)) {
            $message = null;
            foreach ($messagesId as $messageId) {
                try {
                    $message = $this->messagesDAO->findByPrimaryKey($messageId);
                    if(($block && ! $message->isBlocked()) || (! $block && $message->isBlocked())) {
                        $this->messagesDAO->block($message->getId(), $block);
                    }
                } catch(Exception $e) {
                    mdh_handle_error(
                        __("Something went wrong blocking the message(s)", mdh_current_plugin_name()),
                        osc_get_http_referer()
                    );
                }
            }
        }

        mdh_handle_ok(
            __("Successfully blocked the message!", mdh_current_plugin_name()),
            osc_get_http_referer()
        );
	}

    private function doUnblock($block=true)
    {
        $this->doBlock(false);
    }

    /**
     * Display all labels
     * @since 1.50
     */
    private function doLabels()
    {
        try {
            // Get all system labels.
            $labels = $this->labels->findLabels(
                array(
                    "system" => true,
                )
            );
        } catch (Exception $e) {
            mdh_handle_error(
                __("Something went wrong during the process.", mdh_current_plugin_name()),
                $this->getFallbackUrl()
            );
        }

        // Export variables to view.
        $this->_exportVariableToView("mdh_thread_labels", $labels);
    }

    /**
     * Update labels.
     *
     * @since 1.50
     */
    private function doLabelsPost()
    {
        if (!Params::existParam("labels")) {
            // Redirect and failed.
            mdh_handle_error(
                __("Something went wrong during the process.", mdh_current_plugin_name()),
                mdh_messenger_admin_labels_url()
            );
        }

        // Iterate over all labels.
        foreach (Params::getParam("labels") as $id => $titles) {
            try {
                // Find the label.
                $label = $this->labels->findLabel(array("id" => $id));

                // Set old the titles for each locales.
                foreach ($titles as $locale => $title) {
                    $label->setTitle($title, $locale);
                }

                // Update the label.
                $this->labels->updateLabel($label);
            } catch (Exception $e) {
                mdh_handle_error(
                    __("Something went wrong during the process.", mdh_current_plugin_name()),
                    mdh_messenger_admin_events_url()
                );
            }
        }

        mdh_handle_ok(
            __("Successfully update labels!", mdh_current_plugin_name()),
            mdh_messenger_admin_labels_url()
        );
    }

    /**
     * Add a label
     * @since 1.50
     */
    private function doLabelAdd()
    {
        // Get title and slugify.
        $title = Params::getParam("title");
        $name = osc_sanitize_string($title);

        try {
            // Create the label.
            $label = new Madhouse_Messenger_Label();
            $label
                ->setName($name)
                ->setTitle($title)
                ->setSystem(false);

            // Create the label
            $label = $this->labels->createLabel($label);

            // Redirect and success.
            mdh_handle_ok(
                __("Successfully added one label!", mdh_current_plugin_name()),
                mdh_messenger_admin_labels_url()
            );
        } catch (InvalidArgumentException $e) {
            mdh_handle_error(
                __("Fail when adding one label: slug and title can't be empty.", mdh_current_plugin_name()),
                mdh_messenger_admin_labels_url()
            );
        } catch (Exception $e) {
            mdh_handle_error(
                __("Failed while adding the label.", mdh_current_plugin_name()),
                mdh_messenger_admin_labels_url()
            );
        }
    }

    /**
     * Remove a label.
     *
     * @since 1.50
     */
    private function doLabelRemove()
    {
        try {
            // Find the label by its key.
            $label = $this->labels->findLabel(array("id" => Params::getParam("id")));

            // Can't delete a system label.
            if ($label->isSystem()) {
                mdh_handle_error(
                    __("You can't remove a system label.", mdh_current_plugin_name()),
                    mdh_messenger_admin_labels_url()
                );
            }

            // Try to delete the label.
            $this->labels->deleteLabel($label);

            // Redirect and success.
            mdh_handle_ok(
                __("Successfully remove one label!", mdh_current_plugin_name()),
                mdh_messenger_admin_labels_url()
            );
        } catch (Madhouse_NoResultsException $e) {
            mdh_handle_error(
                __("Failed to delete the label: this label doesn't exist.", mdh_current_plugin_name()),
                mdh_messenger_admin_labels_url()
            );
        } catch (Exception $e) {
            mdh_handle_error(
                __("Something went wrong during the process.", mdh_current_plugin_name()),
                mdh_messenger_admin_labels_url()
            );
        }
    }

    /**
     * Display all events
     * @since 1.50
     */
    private function doEvents()
    {
        $events = Madhouse_Messenger_Models_Events::newInstance()->findAll();
        View::newInstance()->_exportVariableToView(
            "mdh_thread_events",
            $events
        );
    }

    /**
     * Update all events description
     * @since 1.50
     */
    private function doEventsPost()
    {
        $params = Params::getParamsAsArray("post", false);

        if (isset($params['events'])) {
            foreach ($params['events'] as $id => $descriptions) {
                try {
                    $object = Madhouse_Messenger_Models_Events::newInstance()->findByPrimaryKey($id);

                    foreach ($descriptions as $locale => $description) {
                        $hasLocale = $object->hasLocale($locale);

                        $excerpt = (isset($description['excerpt']))? $description['excerpt']: "";
                        $text = (isset($description['text']))? $description['text']: "";

                        $object->setExcerpt($excerpt, $locale);
                        $object->setText($text, $locale);

                        if ($hasLocale) {
                            Madhouse_Messenger_Models_Events::newInstance()->updateDescription($object, $locale);
                        } else {
                            Madhouse_Messenger_Models_Events::newInstance()->insertDescription($object, $locale);
                        }
                    }
                } catch (Madhouse_NoResultsException $e) {
                } catch (Madhouse_QueryFailedException $e) {
                    mdh_handle_error(
                        __("Something went wrong during the process.", mdh_current_plugin_name()),
                        mdh_messenger_admin_events_url()
                    );
                }
            }
        }

        mdh_handle_ok(
            __("Successfully update events!", mdh_current_plugin_name()),
            mdh_messenger_admin_events_url()
        );
    }

    /**
     * Display all events
     * @since 1.50
     */
    private function doStatus()
    {
        $status = Madhouse_Messenger_Models_Status::newInstance()->findAll();
        // Load and send view object to the view.
        View::newInstance()->_exportVariableToView(
            "mdh_statuss",
            $status
        );
    }

    /**
     * Update all status description
     * @since 1.50
     */
    private function doStatusPost()
    {
        $params = Params::getParamsAsArray("post");

        if (isset($params['status'])) {
            foreach ($params['status'] as $statusId => $descriptions) {
                try {
                    $status = Madhouse_Messenger_Models_Status::newInstance()->findByPrimaryKey($statusId);

                    foreach ($descriptions as $locale => $description) {
                        $hasLocale = $status->hasLocale($locale);

                        $title = (isset($description['title']))? $description['title']: "";
                        $text = (isset($description['text']))? $description['text']: "";

                        $status->setTitle($title, $locale);
                        $status->setText($text, $locale);

                        if ($hasLocale) {
                            Madhouse_Messenger_Models_Status::newInstance()->updateDescription($status, $locale);
                        } else {
                            Madhouse_Messenger_Models_Status::newInstance()->insertDescription($status, $locale);
                        }
                    }
                } catch (Madhouse_NoResultsException $e) {
                } catch (Madhouse_QueryFailedException $e) {
                    mdh_handle_error(
                        __("Something went wrong during the process.", mdh_current_plugin_name()),
                        mdh_messenger_admin_events_url()
                    );
                }
            }
        }

        mdh_handle_ok(
            __("Successfully update status!", mdh_current_plugin_name()),
            mdh_messenger_admin_status_url()
        );
    }

    /**
     * Add a status
     * @since 1.50
     */
    private function doStatusAdd()
    {
        $title = Params::getParam("title");
        $text  = Params::getParam("text");
        $slug  = osc_sanitize_string($title);

        if (empty($slug) || empty($title) ) {
            mdh_handle_error(
                __("Fail when adding one status. Slug and title can't be empty.", mdh_current_plugin_name()),
                mdh_messenger_admin_status_url()
            );
        }

        try {
            $status = Madhouse_Messenger_Models_Status::newInstance()->findByName($slug);
        } catch (Madhouse_NoResultsException $e) {

        }

        if (!empty($status)) {
            mdh_handle_error(
                __("Fail when adding one status. The slug need to be unique. You need to change your title.", mdh_current_plugin_name()),
                mdh_messenger_admin_status_url()
            );
        }

        mdh_messenger_create_status($slug, $title, $text);

        mdh_handle_ok(
            __("Successfully add one status!", mdh_current_plugin_name()),
            mdh_messenger_admin_status_url()
        );
    }

    /**
     * Remove a status
     * @since 1.50
     */
    private function doStatusRemove()
    {
        $id = Params::getParam("id");

        try {
            $status = Madhouse_Messenger_Models_Status::newInstance()->findByPrimaryKey($id);
        } catch (Madhouse_NoResultsException $e) {
            mdh_handle_error(
                __("This status doesn't exist. Failed to delete it.", mdh_current_plugin_name()),
                mdh_messenger_admin_status_url()
            );
        }

        Madhouse_Messenger_Models_Status::newInstance()->remove($status);

        mdh_handle_ok(
            __("Successfully remove one status!", mdh_current_plugin_name()),
            mdh_messenger_admin_status_url()
        );
    }

	public function doContact()
	{
	    $url = osc_admin_base_url(true) . "?page=users";

	    if(! osc_get_preference("moderation_user", mdh_current_preferences_section())) {
	        mdh_handle_error(
	            __("Please, head to settings to select a moderation user.", mdh_current_plugin_name()),
	            $url
	        );
	    }

	    // Gets the user to contact.
	    $this->_exportVariableToView("user", User::newInstance()->findByPrimaryKey(Params::getParam("recipients")));

	    // If 'message' exists, it means a message is sent.
	    if(Params::existParam("message")) {
	        // Contact the user with the moderator account as sender.
	        try {
                // Get moderation user to send the message in his name.
                $moderationUser = Madhouse_Utils_Models::findUserByPrimaryKey(
                    osc_get_preference("moderation_user", mdh_current_preferences_section())
                );

                // Get the recipient.
                $recipients = array(Madhouse_Utils_Models::findUserByPrimaryKey(Params::getParam("recipients")));

                // Create the message object.
                $message = new Madhouse_Messenger_Message(Params::getParam("message"), $moderationUser, $recipients);

                // Actually send the message.
    	        $this->workflow->contact($message);
    	    } catch (Madhouse_Messenger_EmptyMessageException $e) {
    	        mdh_handle_error(__("Can't send an empty message.", mdh_current_plugin_name()), $url);
    	    } catch (Madhouse_Messenger_NoValidRecipientsException $e) {
    	        mdh_handle_error(__("Select a user to send the message to and choose the 'Contact' action.", mdh_current_plugin_name()), $url);
    	    } catch (Exception $e) {
    	        mdh_handle_error(__("An error occured while performing the task.", mdh_current_plugin_name()), $url);
    	    }

	        mdh_handle_ok(__("Successfully sent the message!", mdh_current_plugin_name()), $url);
	    }
	}

    public function doUpgrade()
    {
        $pluginInfo = Plugins::getInfo(mdh_current_plugin_name(true));

        $this->_exportVariableToView(
            "installed_version",
            osc_get_preference("version", mdh_current_preferences_section())
        );
        $this->_exportVariableToView(
            "current_version",
            $pluginInfo["version"]
        );

        $this->_exportVariableToView(
            "mdh_threads_count",
            Madhouse_Messenger_Models_Threads::newInstance()->count()
        );
    }

    public function doUpgradePost()
    {
        // Current version.
        $current = Plugins::getInfo(mdh_current_plugin_name(true));

        // Installed version.
        $installed = osc_get_preference("version", mdh_current_preferences_section());

        /*
         * 'version' is not set in the oc_t_preference table.
         * Assume that installed is 1.2X since version exists since 1.30 and 1.20
         * has been the first public version of the plugin. See CHANGELOG.
         */
        try {
            Madhouse_Messenger_Plugin::upgrade();
        } catch (Exception $e) {
            mdh_handle_error(
                __("An error occured while performing the upgrade.", mdh_current_plugin_name()),
                mdh_messenger_admin_dashboard_url()
            );
        }

        mdh_handle_ok(
            __("Well done. Successfully updated messenger!", mdh_current_plugin_name()),
            mdh_messenger_admin_dashboard_url()
        );
    }

	public function doModel()
	{
        parent::doModel();

        switch (Params::getParam("route")) {
            case mdh_current_plugin_name() . "_upgrade":
                $this->doUpgrade();
            break;
            case mdh_current_plugin_name() . "_upgrade":
                $this->doUpgradePost();
            break;
            case mdh_current_plugin_name() . "_listing":
                $this->doMessages();
            break;
            case mdh_current_plugin_name() . "_settings":
                $this->doSettings();
            break;
            case mdh_current_plugin_name() . "_settings_post":
                $this->doSettingsPost();
            break;
            case mdh_current_plugin_name() . "_message_unblock":
                $this->doUnblock();
            break;
            case mdh_current_plugin_name() . "_message_block":
                $this->doBlock();
            break;
            case mdh_current_plugin_name() . "_contact":
                $this->doContact();
            break;
            case mdh_current_plugin_name() . "_labels":
                $this->doLabels();
            break;
            case mdh_current_plugin_name() . "_labels_post":
                $this->doLabelsPost();
            break;
            case mdh_current_plugin_name() . "_label_add":
                $this->doLabelAdd();
            break;
            case mdh_current_plugin_name() . "_label_remove":
                $this->doLabelRemove();
            break;
            case mdh_current_plugin_name() . "_events":
                $this->doEvents();
            break;
            case mdh_current_plugin_name() . "_events_post":
                $this->doEventsPost();
            break;
            break;
            case mdh_current_plugin_name() . "_status":
                $this->doStatus();
            break;
            case mdh_current_plugin_name() . "_status_post":
                $this->doStatusPost();
            break;
            case mdh_current_plugin_name() . "_status_add":
                $this->doStatusAdd();
            break;
            case mdh_current_plugin_name() . "_status_remove":
                $this->doStatusRemove();
            case mdh_current_plugin_name() . "_blocked_users":
                $this->doBlockedUsers();
            break;
            case mdh_current_plugin_name() . "_unblock_user":
                $this->doUnblockedUser();
            break;
            case mdh_current_plugin_name() . "_dashboard":
            default:
                $this->doDashboard();
            break;
        }
	}
}

?>
