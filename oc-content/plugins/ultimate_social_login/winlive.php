<?php
$code = $_GET['code'];

if($code) {
    header('Location: /index.php?page=custom&route=usl-live&code=' . $code);
    exit();
}

exit('Access denied');