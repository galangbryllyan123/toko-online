<?php defined('ABS_PATH') or die('Access denied');
/**
 * Url helpers
 */
function usl_is_settings_page() {
    return (Params::getParam('route')=='usl-settings');
}

function usl_is_help_page() {
    return (Params::getParam('route')=='usl-help');
}