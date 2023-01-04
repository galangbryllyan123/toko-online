<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <?php osc_current_web_theme_path('head.php') ; ?>
    </head>
    <body>
        <div class="container">
            <?php osc_current_web_theme_path('header.php') ; ?>
            <div class="content user_forms">
                <div class="inner">
                    <h1><?php _e('Recommend to a friend', 'masjob') ; ?></h1>
                    <?php SendFriendForm::js_validation() ; ?>
                    <form id="send-friend" name="send-friend" action="<?php echo osc_base_url(true) ; ?>" method="post">
                        <fieldset>
                            <input type="hidden" name="action" value="send_friend_post" />
                            <input type="hidden" name="page" value="item" />
                            <input type="hidden" name="id" value="<?php echo osc_item_id() ; ?>" />
                            <label><?php _e('Job offer', 'masjob') ; ?>: <a href="<?php echo osc_item_url() ; ?>"><?php echo osc_item_title() ; ?></a></label><br/>
                            <label for="yourName"><?php _e('Your name', 'masjob') ; ?></label> <?php SendFriendForm::your_name() ; ?> <br/>
                            <label for="yourEmail"><?php _e('Your e-mail address', 'masjob') ; ?></label> <?php SendFriendForm::your_email() ; ?> <br/>
                            <label for="friendName"><?php _e("Your friend's name", 'masjob') ; ?></label> <?php SendFriendForm::friend_name() ; ?> <br/>
                            <label for="friendEmail"><?php _e("Your friend's e-mail address", 'masjob') ; ?></label> <?php SendFriendForm::friend_email() ; ?> <br/>
                            <label for="message"><?php _e('Message', 'masjob') ; ?></label> <?php SendFriendForm::your_message() ; ?> <br/>
                            <button onclick="return validate_form() ;" type="button"><?php _e('Send', 'masjob') ; ?></button>
                        </fieldset>
                    </form>
                </div>
            </div>
            <?php osc_current_web_theme_path('footer.php') ; ?>
        </div>
        <?php osc_show_flash_message() ; ?>
    </body>
</html>