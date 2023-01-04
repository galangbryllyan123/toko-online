<?php 
    $action = Params::getParam('do');
    
    if($action == 'google-auth') {
        $google_arr = array('email' => Params::getParam('email'), 'displayName' => Params::getParam('name'));
        
        USLUserAuth::newInstance()->userAuth('google', $google_arr);
    }
?>