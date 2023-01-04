<?php defined('ABS_PATH') or die('Access denied');

$providers = array_values(USLUserAuth::socNetworkList());
$provider = Params::getParam('l');

if (in_array($provider, $providers)) { 
    $check_auth = USLUserAuth::newInstance()->userAuth($provider);
    
    if($check_auth) {
        USLUserAuth::newInstance()->redirect(osc_user_dashboard_url());
    }
    else {
        USLUserAuth::newInstance()->redirect(osc_user_login_url());
    }
}
else {
    USLUserAuth::newInstance()->redirect(osc_user_login_url());
}
exit;