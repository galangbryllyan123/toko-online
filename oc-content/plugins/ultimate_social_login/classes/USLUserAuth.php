<?php defined('ABS_PATH') or die('Access denied');

use Abraham\TwitterOAuth\TwitterOAuth;

class USLUserAuth {
    
    private static $instance;
    
    public $h_auth, $h_adapter, $h_provider;
    
    public $check_provider = FALSE;
    
    function __construct() {
        /**
         * Init hooks
         */
        osc_add_hook('usl_auth_buttons', array(&$this, 'usl_auth_buttons'));
        
        /**
         * Routes
         */   
        osc_add_route('usl-auth', 'usl-auth', 'usl-auth', 'ultimate_social_login/user/auth.php');
        osc_add_route('usl-endpoint', 'ultimate_social_login/connect', 'ultimate_social_login/connect', 'ultimate_social_login/user/endpoint.php');
        
        if (Params::getParam('route') == 'usl-live') {
            osc_add_route('usl-live', 'ultimate_social_login/live', 'ultimate_social_login/live', 'ultimate_social_login/libs/hybridauth/live.php');
            require_once osc_plugins_path() . 'ultimate_social_login/libs/hybridauth/live.php';
        }
        
        osc_add_route('usl-twitter-auth', 'ultimate_social_login/usl-twitter-auth/(.+)/(.+)', 'ultimate_social_login/usl-twitter-auth/{oauth_token}/{oauth_verifier}', 'ultimate_social_login/user/twitter-auth.php');
    }
    
    public static function newInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }

        return self::$instance;
    }
    
    public static function socNetworkList() {
        $networks = array(
                        'fb' => 'Facebook',
                        'gg' => 'Google',
                        'tw' => 'Twitter',
                        'inst' => 'Instagram',
                        'lin' => 'LinkedIn',
                        'win' => 'Live',
                        'yh' => 'Yahoo',
                        'ok' => 'Odnoklassniki',
                        'vk' => 'Vkontakte',
                        'ml' => 'Mailru',
                        'yx' => 'Yandex'
                        );
        
        return $networks;
    }
    
    private function initConfig() {
        require_once osc_plugins_path() . 'ultimate_social_login/libs/hybridauth/Hybrid/Auth.php';;
        
        if(osc_rewrite_enabled ()) {
            $google_redirect = osc_base_url() . 'ultimate_social_login/connect?hauth.done=Google';
            $yandex_redirect = osc_base_url() . 'ultimate_social_login/connect?hauth.done=Yandex';
            $facebook_redirect = osc_base_url() . 'ultimate_social_login/connect?hauth_done=Facebook';
			$instagram_redirect = osc_base_url() . 'ultimate_social_login/connect?hauth.done=Instagram';
			$linkedin_redirect = osc_base_url() . 'ultimate_social_login/connect?hauth.done=LinkedIn';
        }
        else {
            $google_redirect = osc_base_url() . 'index.php?page=custom&route=usl-endpoint&hauth.done=Google';
            $yandex_redirect = osc_base_url() . 'index.php?page=custom&route=usl-endpoint&hauth.done=Yandex';
            $facebook_redirect = osc_base_url() . 'index.php?page=custom&route=usl-endpoint&hauth_done=Facebook';
			$instagram_redirect = osc_base_url() . 'index.php?page=custom&route=usl-endpoint&hauth_done=Instagram';
			$linkedin_redirect = osc_base_url() . 'index.php?page=custom&route=usl-endpoint&hauth_done=LinkedIn';
        }
        
        $config = array(
            "base_url" => osc_route_url('usl-endpoint'),
            "providers" => array(
                "Facebook" => array(
                    "enabled" => osc_get_preference('fb_status', 'usl_settings'),
                    "keys" => array(
                        "id" => osc_get_preference('fb_id', 'usl_settings'), 
                        "secret" => osc_get_preference('fb_secret', 'usl_settings')
                    ),
                    "scope"   => "email",
                    "redirect_uri" => $facebook_redirect
                ),
                "Instagram" => array(
                    "enabled" => osc_get_preference('inst_status', 'usl_settings'),
                    "keys" => array(
                        "id" => osc_get_preference('inst_id', 'usl_settings'), 
                        "secret" => osc_get_preference('inst_secret', 'usl_settings')
                    ),
					"redirect_uri" => $instagram_redirect
                ),
                "LinkedIn" => array(
                    "enabled" => osc_get_preference('lin_status', 'usl_settings'),
                    "keys" => array(
                        "id" => osc_get_preference('lin_id', 'usl_settings'), 
                        "secret" => osc_get_preference('lin_secret', 'usl_settings')
                    ),
                    "scope"   => array("r_basicprofile", "r_emailaddress"),
					"redirect_uri" => $linkedin_redirect
                ),
                "Live" => array(
                    "enabled" => osc_get_preference('win_status', 'usl_settings'),
                    "keys" => array(
                        "id" => osc_get_preference('win_id', 'usl_settings'), 
                        "secret" => osc_get_preference('win_secret', 'usl_settings')
                    ),
					'redirect_uri' => osc_base_url() . 'oc-content/plugins/ultimate_social_login/winlive.php'
                ),
                "Yahoo" => array(
                    "enabled" => osc_get_preference('yh_status', 'usl_settings'),
                    "keys" => array(
                        "id" => osc_get_preference('yh_id', 'usl_settings'), 
                        "secret" => osc_get_preference('yh_secret', 'usl_settings'),
                        //"scope"   => ['openid' ,'mail-r', 'sdpp-w']
                    )
                ),
                "Odnoklassniki" => array(
                    "enabled" => osc_get_preference('ok_status', 'usl_settings'),
                    "keys" => array(
                        "id" => osc_get_preference('ok_id', 'usl_settings'), 
                        "key" => osc_get_preference('ok_public', 'usl_settings'), 
                        "secret" => osc_get_preference('ok_secret', 'usl_settings')
                    )
                ),
                "Vkontakte" => array(
                    "enabled" => osc_get_preference('vk_status', 'usl_settings'),
                    "keys" => array(
                        "id" => osc_get_preference('vk_id', 'usl_settings'), 
                        "secret" => osc_get_preference('vk_secret', 'usl_settings')
                    ),
                    "scope"   => "email"
                ),
                "Mailru" => array(
                    "enabled" => osc_get_preference('ml_status', 'usl_settings'),
                    "keys" => array(
                        "id" => osc_get_preference('ml_id', 'usl_settings'), 
                        "secret" => osc_get_preference('ml_secret', 'usl_settings')
                    )
                ),
                "Yandex" => array(
                    "enabled" => osc_get_preference('yx_status', 'usl_settings'),
                    "keys" => array(
                        "id" => osc_get_preference('yx_id', 'usl_settings'), 
                        "secret" => osc_get_preference('yx_secret', 'usl_settings')
                    ),
                    "redirect_uri" => $yandex_redirect
                )
            ),
            "debug_mode" => false,
            "debug_file" => ""
        );
        
        $this->h_auth = new Hybrid_Auth($config);
    }
    
    public function userAuth($provider, $arr = '') {

        try { 
            if($provider == 'google') {
                $this->check_provider = TRUE;
                $userProfile = $arr;
            }
            else {
                if(!$this->h_auth) $this->initConfig(); 
                $this->h_provider = $provider; 
                $this->h_adapter = $this->h_auth->authenticate($this->h_provider); 
                $userProfile = (array)$this->h_adapter->getUserProfile();
                $networks = USLModel::newInstance()->getSocNetworks();
                
                foreach($networks as $network) {
                    if($provider == preg_replace("/(Windows\s)|([\.\+])/",'',$network['usl_name'])) {
                        $this->check_provider = TRUE;
                        break;
                    }
                }
            }
            
            if($this->check_provider) {
                if($provider == 'Instagram') {
                    $checkUser = $this->checkUserExist($userProfile['username'] . '@instagram.com');
                }
				elseif($provider == 'Odnoklassniki') {
                    $checkUser = $this->checkUserExist($userProfile['identifier'] . '@ok.ru');
                }
                else {
                    $checkUser = $this->checkUserExist($userProfile['email']);
                }
                
                if($checkUser) {
                    $checkBaned = $this->checkUserBans($userProfile['email']);
                    
                    if(!$checkBaned) {
                        $user = User::newInstance();
                        $user->update(array('b_active' => '1'), array('pk_i_id' => $checkUser['pk_i_id']));
                        
                        require_once osc_lib_path() . 'osclass/UserActions.php';
                        $userActions = new UserActions(false);
                        osc_add_flash_ok_message(sprintf( __('You have been successfully authorized.', 'ultimate_social_login'), osc_page_title()));
                        
                        $auth = $userActions->bootstrap_login($checkUser['pk_i_id']);
                        
                        return TRUE;
                    }
                    else {
                        osc_add_flash_error_message(__('Your authorization was declined.', 'ultimate_social_login'));
                        
                        return FALSE;
                    }
                }
                else {
                    $this->userSignup($userProfile, $provider) ;
                }
            }
            else {
                osc_add_flash_error_message(__('Social provider not allowed.', 'ultimate_social_login'));
            }
        }
        catch (Exception $e) {
            switch($e->getCode()) {
                case 0 : 
    				osc_add_flash_error_message(__( "Unknown error.",'ultimate_social_login'));
    				break;
    			case 1 :
    				osc_add_flash_error_message(__("Authentication configuration error.",'ultimate_social_login'));
    				break;
    			case 2 :
    				osc_add_flash_error_message(__("Provider is not correctly configured.",'ultimate_social_login'));
    				break;
    			case 3 :
    				osc_add_flash_error_message(__("Unknown or disabled provider.",'ultimate_social_login'));
    				break;
    			case 4 :
    				osc_add_flash_error_message(__("No credentials provider applications.",'ultimate_social_login'));
    				break;
    			case 5 : 
    				osc_add_flash_error_message(__("Authentication failed. The user canceled the authentication or the provider declined the connection.",'ultimate_social_login'));
    				break;
    			case 6 : 
    				osc_add_flash_error_message(__("Request User profile failed. Most likely, the user is not connected to the provider and he must authenticate again.",'ultimate_social_login'));
    				break;
    			case 7 : 
    				osc_add_flash_error_message(__("The user is not connected to the provider.",'ultimate_social_login'));
    				break;
    			case 8 : 
    		        osc_add_flash_error_message(__("The provider does not support this feature.",'ultimate_social_login'));
    				break;
            }

            return FALSE;
        }
        
        return FALSE;
    }
    
    public function userSignup($userProfile, $provider) {
        $userData['dt_reg_date'] = date('Y-m-d H:i:s');
        
        switch($provider) {
            case 'Vkontakte' :
                $userData['s_name'] = substr($userProfile['email'], 0, strpos($userProfile['email'], '@'));
                $userData['s_username'] = substr($userProfile['email'], 0, strpos($userProfile['email'], '@'));
                $userData['s_email'] = $userProfile['email'];
            break;
            
            case 'Instagram' :
                $userData['s_name'] = $userProfile['displayName'];
                $userData['s_username'] = $userProfile['username'];
                $userData['s_email'] = $userProfile['username'] . '@instagram.com';
            break;
			
			case 'Odnoklassniki' :
                $userData['s_name'] = $userProfile['displayName'];
                $userData['s_username'] = $userProfile['identifier'];
                $userData['s_email'] = $userProfile['identifier'] . '@ok.ru';
            break;
            
            default :
                $userData['s_name'] = $userProfile['displayName'];
                $userData['s_username'] = substr($userProfile['email'], 0, strpos($userProfile['email'], '@'));
                $userData['s_email'] = $userProfile['email'];
            break;
        }
        
        $userData['s_password'] = osc_genRandomPassword();
        $userData['s_secret'] = osc_genRandomPassword();
		$userData['dt_reg_date'] = date('Y-m-d H:i:s');
		$userData['dt_mod_date'] = date('Y-m-d H:i:s');
        
        $user = User::newInstance();
        $user->insert($userData) ;
        $userID = $user->dao->insertedId();
        
        osc_run_hook('user_register_completed', $userID);
        $userDB = $user->findByPrimaryKey($userID);
        
        if(osc_notify_new_user()) {
            osc_run_hook('hook_email_admin_new_user', $userDB);
        }
        
        $user->update(array('b_active' => '1'), array('pk_i_id' => $userID));
        
        osc_run_hook('hook_email_user_registration', $userDB);
        osc_run_hook('validate_user', $userDB);
        osc_add_flash_ok_message(sprintf( __('Your account has been successfully created.', 'ultimate_social_login'), osc_page_title()));
        
        require_once osc_lib_path() . 'osclass/UserActions.php';
        
		$userActions = new UserActions(false);
		$auth = $userActions->bootstrap_login($userID);
        
        return TRUE;
    }
    
    public function endpoint(){
        require_once osc_plugins_path() . 'ultimate_social_login/libs/hybridauth/Hybrid/Endpoint.php';
        
        if(!$this->h_auth) $this->initConfig(); 
        Hybrid_Endpoint::process();
    }
    
    public function checkUserExist($email) {
        $user = User::newInstance();
        $checkUser = $user->findByEmail($email);
        
        if(count($checkUser) > 0) return $checkUser;
        
        return FALSE;
    }
    
    public function checkUserBans($email) {
        $banned = osc_is_banned($email);
        
        if($banned != 1 || $banned != 2) return FALSE;
        
        return TRUE;
    }
    
    public function redirect($url) {
        header("Location:" . $url);
    }
    
    function usl_auth_buttons() {
        $networks = USLModel::newInstance()->getSocNetworks();
        $btns = '';
        
        foreach($networks as $network) {
            $images = usl_get_soc_icons();
            $status = $network['usl_code'] . '_status'; $id = $network['usl_code'] . '_id'; $secret = $network['usl_code'] . '_secret';
            
            if(osc_get_preference($status,'usl_settings') && osc_get_preference($id,'usl_settings') && osc_get_preference($secret,'usl_settings')) {
                
                if($network['usl_name'] == 'Twitter') {
                    require_once osc_plugins_path() . 'ultimate_social_login/libs/twitter/autoload.php';
                    
                    define('CONSUMER_KEY', osc_get_preference('tw_id', 'usl_settings'));
                    define('CONSUMER_SECRET', osc_get_preference('tw_secret', 'usl_settings'));
                    define('OAUTH_CALLBACK', osc_base_url() . 'oc-content/plugins/ultimate_social_login/twitter.php');
                    
                    $twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
                    $result = $twitter->oauth('oauth/request_token', ['oauth_callback' => OAUTH_CALLBACK]);
                    $request_auth_token = $result['oauth_token'];
                    
                    $href = $twitter->url('oauth/authorize', ['oauth_token' => $request_auth_token]); 
                    
                    if(osc_rewrite_enabled()) file_put_contents(osc_plugins_path() . 'ultimate_social_login/rewrite.txt', 'yes');
                        else file_put_contents(osc_plugins_path() . 'ultimate_social_login/rewrite.txt', 'no');
                }
                else {
                    $params = array('l' => preg_replace("/(Windows\s)|([\.\+])/",'',$network['usl_name']));
                    $href = osc_route_url('usl-auth', $params);
                }
                
                $img = $images[$network['usl_code'] . '_ico'];
                
                if($network['usl_code'] == 'gg') {
                    $btns .= '<meta name="google-signin-scope" content="profile email">
                              <meta name="google-signin-client_id" content="' . osc_get_preference('gg_id', 'usl_settings') . '">
                              <script src="https://apis.google.com/js/platform.js" async defer></script>';
                    $btns .= '<a class="g-signin2" data-onsuccess="google_signin" data-theme="dark" href="javascript: void(0);" title="' . __( $network['usl_name'], 'ultimate_social_login' ) . '">' . $img . '</a>';
                }
                else {
                    $btns .= '<a href="' . $href . '" title="' . __( $network['usl_name'], 'ultimate_social_login' ) . '">' . $img . '</a>';
                } 
            }
        }
        
        if($btns) $tmpl = '<div class="usl-buttons">' . $btns . '</div>';
        
        echo $tmpl;
        
        require_once USL_USR_FOLDER . 'login-btns.php';
    }
}