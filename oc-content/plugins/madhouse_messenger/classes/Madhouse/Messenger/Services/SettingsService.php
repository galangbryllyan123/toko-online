<?php

class Madhouse_Messenger_Services_SettingsService
{
    const DELETE_MODE_ONE = 0;
    const DELETE_MODE_ALL = 1;

    public static function newInstance()
    {
        return new self();
    }

    public function __construct()
    {
    }

    public function getResourceExtensionList()
    {
        // Get allowed extensions from settings.
        $extensionsWhitelist = osc_get_preference('resources_extensions_whitelist', mdh_current_preferences_section());

        // Split and sanitize (trim).
        $extensionsWhitelist = array_map(
            function ($extension) {
                return trim($extension);
            },
            explode(",", $extensionsWhitelist)
        );

        return $extensionsWhitelist;
    }

    public function getResourceMaxSize()
    {
        $maxSizeKb = osc_get_preference('resources_max_size_kb', mdh_current_preferences_section());
        if ($maxSizeKb) {
            return $maxSizeKb;
        }

        // Fallback to Osclass value.
        return osc_max_size_kb();
    }

    public function getDeleteMode()
    {
        return (int) osc_get_preference('delete_mode', mdh_current_preferences_section());
    }

    /**
     * Contact mode, registered only or registered and non-registered.
     *
     * @return boolean
     */
    public function isRegisteredOnlyEnabled()
    {
        return (osc_reg_user_can_contact()) ? true : false;
    }

    /**
     * Attachment enabled or not?
     *
     * @return boolean
     */
    public function isAttachementEnabled()
    {
        return (osc_item_attachment()) ? true : false;
    }
}
