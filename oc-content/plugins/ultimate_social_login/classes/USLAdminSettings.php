<?php defined('ABS_PATH') or die('Access denied');

class USLAdminSettings {
    
    function __construct() {
        /**
         * Init hooks
         */
        osc_add_hook('admin_menu_init', array(&$this, 'usl_admin_menu'));
        osc_add_hook('admin_header', array(&$this, 'usl_init_admin_page_header'));
        osc_add_hook('init_admin', array(&$this, 'usl_admin_settings_update'));

        /**
         * Routes
         */   
        osc_add_route('usl-settings', 'usl-settings', 'usl-settings', USL_ADM_FOLDER . 'settings.php');
        osc_add_route('usl-help', 'usl-help', 'usl-help', USL_ADM_FOLDER . 'help.php');
        
        if(Params::getParam('ajax') == 'sorting') $this->socNetworkPositionsUpdate();
    }
    
    function usl_admin_menu() {
            osc_admin_menu_plugins('USLogin', osc_route_admin_url('usl-settings'), 'usl-settings-menu');
        }
        
    function usl_init_admin_page_header() {
        $_r = Params::getParam('route');
        
        switch ($_r) {
            case 'usl-settings':
            case 'usl-help':
                osc_register_script('switch-js', USL_ADM_JS . 'hurkanSwitch.js');
                osc_enqueue_script('switch-js');
                osc_enqueue_style('switch-css', USL_ADM_STYLE . 'hurkanSwitch.css');
                osc_enqueue_style('ultimate-social-login', USL_ADM_STYLE . 'style.css');
                osc_enqueue_style('accordion-css', USL_ADM_STYLE . 'accordion.css');
				osc_enqueue_style('fontawesome-css', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
                osc_remove_hook('admin_page_header', 'customPageHeader');
                osc_add_hook('admin_page_header', array(&$this, 'usl_admin_page_header'));
                break;
            default:
                break;
        }
    }
    
    function usl_admin_page_header() {
        echo '<h1>Ultimate Social Login</h1>';
    }
    
    function usl_admin_settings_update() {
        if(osc_is_admin_user_logged_in() && Params::getParam('route') == 'usl-settings' && Params::getParam('plugin_action') == 'edit') {
            $networks = USLModel::newInstance()->getSocNetworks();
            
            foreach($networks as $network) {
                osc_set_preference($network['usl_code'] . '_id', trim(Params::getParam($network['usl_code'] . "_id")), 'usl_settings', 'STRING');
                osc_set_preference($network['usl_code'] . '_secret', trim(Params::getParam($network['usl_code'] . "_secret")), 'usl_settings', 'STRING');
                if($network['usl_code'] == 'ok') osc_set_preference('ok_public', trim(Params::getParam("ok_public")), 'usl_settings', 'STRING');
                osc_set_preference($network['usl_code'] . '_status', Params::getParam($network['usl_code'] . "_status") == 1 ? 1:0, 'usl_settings', 'STRING');
            }
            
            osc_add_flash_ok_message(__('Configuration has been updated', 'ultimate_social_login'), 'admin');
            osc_redirect_to(osc_route_admin_url('usl-settings'));
        }
    }
    
    public static function uslAdminGetSettings() {
        $data = array();
        $networks = USLModel::newInstance()->getSocNetworks();
        
        foreach($networks as $network) {
            $data[$network['usl_code'] . '_id'] = osc_get_preference($network['usl_code'] . '_id','usl_settings');
            $data[$network['usl_code'] . '_secret'] = osc_get_preference($network['usl_code'] . '_secret','usl_settings');
            if($network['usl_code'] == 'ok') $data['ok_public'] = osc_get_preference('ok_public','usl_settings');
            $data[$network['usl_code'] . '_status'] = osc_get_preference($network['usl_code'] . '_status','usl_settings');
        }
        
        return $data;
    }
    
    public function sortNetworks($ids) {        
    	$position = 1;
        
    	foreach($ids as $id){
            $result = USLModel::newInstance()->updateSocNetworkPositions($id, $position);
    		$position++;
    	}
        
    	$result = USLModel::newInstance()->getSocNetworks();
    	
    	return $result;
    }
    
    public function socNetworkPositionsUpdate() {
        $ids = $_POST['ids'];
        $result = $this->sortNetworks($ids);
        
        if(!$result) echo 'Error';
        
        exit();
    }
}