<?php 
    $oauth_token = $_GET['oauth_token'];
    $oauth_verifier = $_GET['oauth_verifier'];
    
    if($oauth_token && $oauth_verifier) {
        if(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/oc-content/plugins/ultimate_social_login/rewrite.txt') == 'yes') 
            $redirect = '/ultimate_social_login/usl-twitter-auth/' . $oauth_token . '/' . $oauth_verifier;
        else 
            $redirect = '/index.php?page=custom&route=usl-twitter-auth&oauth_token=' . $oauth_token . '&oauth_verifier=' . $oauth_verifier;
        header('Location: ' . $redirect);
    }
    
    exit();
?>