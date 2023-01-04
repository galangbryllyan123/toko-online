<?php defined('ABS_PATH') or die('Access denied');
    require_once osc_plugins_path() . 'ultimate_social_login/libs/twitter/autoload.php';
    use Abraham\TwitterOAuth\TwitterOAuth;
    
    define('TWITTER_KEY', osc_get_preference('tw_id', 'usl_settings'));
    define('TWITTER_SECRET', osc_get_preference('tw_secret', 'usl_settings'));
    
    $twitter = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET);
    
    if (Params::getParam('oauth_token') && Params::getParam('oauth_verifier')) {
        try {
            $oauth_token = Params::getParam('oauth_token');
            $oauth_verifier = Params::getParam('oauth_verifier');
            $access_token = $twitter->oauth("oauth/access_token", ["oauth_token" => $oauth_token, "oauth_verifier" => $oauth_verifier]);
    
            $user_auth_token = $access_token['oauth_token'];
            $user_secret_token = $access_token['oauth_token_secret'];
            
            $connect = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, $user_auth_token, $user_secret_token);
            $content = $connect->get("account/verify_credentials", ["include_email" => true]);
            
            $user_profile = array(
                                'displayName' => $content->screen_name,
                                'email' => $content->email
                            );
            
            $check_user = USLUserAuth::newInstance()->checkUserExist($user_profile['email']);
            
            if($check_user) {
                $checkBaned = USLUserAuth::newInstance()->checkUserBans($user_profile['email']);
                
                if(!$checkBaned) {
                    $user = User::newInstance();
                    $user->update(array('b_active' => '1'), array('pk_i_id' => $check_user['pk_i_id']));
                    
                    require_once osc_lib_path() . 'osclass/UserActions.php';
                    $userActions = new UserActions(false);
                    osc_add_flash_ok_message(sprintf( __('You have been successfully authorized.', 'ultimate_social_login'), osc_page_title()));
                    
                    $auth = $userActions->bootstrap_login($check_user['pk_i_id']);
                    
                    USLUserAuth::newInstance()->redirect(osc_user_dashboard_url());
                }
                else {
                    osc_add_flash_error_message(__('Your authorization was declined.', 'ultimate_social_login'));
                    
                    USLUserAuth::newInstance()->redirect(osc_user_login_url());
                }
            }
            else {
                USLUserAuth::newInstance()->userSignup($user_profile, 'Twitter') ;
                
                USLUserAuth::newInstance()->redirect(osc_user_dashboard_url());
            }
            
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
?>