<?php

/*
 * ========================================================================================
 *
 * TO CUSTOMIZE
 *
 * COPY THIS FILE TO YOUR THEME IN
 * oc-content/themes/{your_theme_name}/plugins/madhouse_messenger/thread.php
 *
 * FOR TRANSLATION, RENAME ALL "madhouse_messenger" in this file by "your_theme_name"
 * Then update your po and mo file of your theme
 *
 * ========================================================================================
 */

/*
 * ========================================================================================
 * /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
 * REMOVE THE LINE UNDER IF YOU COPY THIS VIEW ON YOUR THEME
 * /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
 * ========================================================================================
 */

Madhouse_Utils_Plugins::overrideView();

/**
 * ========================================================================================
 * /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
 * REMOVE THE LINE AVOVE IF YOU COPY THIS VIEW ON YOUR THEME
 * /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
 * ========================================================================================
 */

?>

<link rel="stylesheet" type="text/css" href="<?php echo osc_plugin_url(""); ?>madhouse_messenger/assets/css/dist/web.css" />
<script type="text/javascript" src="<?php echo osc_plugin_url(""); ?>madhouse_messenger/assets/js/dist/web.min.js"></script>

<div class="messenger">
    <h2>
        <?php echo mdh_thread_title_default(__("Talking with",  "madhouse_messenger") . " ") ?>
    </h2>
    <?php if (osc_get_preference('subject_edit_enabled', mdh_current_preferences_section())): ?>
        <div class="messenger-box js-thread-title-container" style="display:none">
            <div class="row">
                <div class="col-xs-12">
                    <form class="thread-title-form form-inline js-messenger-form" action="<?php echo mdh_messenger_title_url(); ?>" method="POST" enctype="multipart/form-data">
                        <?php if (Params::existParam("secret")): ?>
                            <input type="hidden" name="secret" value="<?php echo Params::getParam("secret"); ?>" />
                        <?php endif; ?>
                        <?php if (Params::existParam("email")): ?>
                            <input type="hidden" name="email" value="<?php echo Params::getParam("email"); ?>" />
                        <?php endif; ?>
                        <input type="hidden" name="tid" value="<?php echo Params::getParam("id"); ?>" />
                        <div class="form-inline">
                            <div class="form-group control-group">
                                <label class="control-label"><?php _e('Subject', 'madhouse_messenger'); ?></label>
                                <input autocomplete="no" class="form-control control-form" type="text" name="subject" value="<?php echo osc_esc_html((Session::newInstance()->_getForm('pp_subject') != '')?Session::newInstance()->_getForm('pp_subject') : mdh_thread()->getTitle()) ?>" />
                            </div>
                            <button class="btn btn-primary" type="submit">
                                <?php _e("Update", "madhouse_messenger"); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif ?>
    <div class="row">
        <div class="col-sm-9">
            <div class="">
                <?php if(mdh_thread()->isBlocked() && !mdh_thread()->isGroup()): ?>
                    <div class="alert alert-danger">
                        <?php printf(__("You blocked the user %s. He/She can't send you messages.", "madhouse_messenger"), mdh_thread()->getOther()->getName()); ?>
                    </div>
                <?php endif; ?>
                <div class="messenger-box messenger-content">
                    <form class="form-vertical js-messenger-form" action="<?php echo mdh_messenger_send_url(); ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="tid" value="<?php echo Params::getParam("id"); ?>" />
                        <?php if (Params::existParam("secret")): ?>
                            <input type="hidden" name="secret" value="<?php echo Params::getParam("secret"); ?>" />
                        <?php endif; ?>
                        <?php if (Params::existParam("email")): ?>
                            <input type="hidden" name="email" value="<?php echo Params::getParam("email"); ?>" />
                        <?php endif; ?>
                        <div class="control-group form-group">
                            <div class="controls">
                                <textarea rows="8" class="" name="message" placeholder="<?php _e("Write something...", "madhouse_messenger"); ?>" rows="3"><?php echo osc_esc_html((Session::newInstance()->_getForm('pp_message') != '')?Session::newInstance()->_getForm('pp_message'):"")?></textarea>
                            </div>
                        </div>
                        <?php if (mdh_messenger_resources_enabled()): ?>
                            <div class="js-attachment-container" style="display:none">
                                <div
                                    class="control-group form-group js-attachment-wrapper clearfix"
                                    data-attachment-max="<?php echo osc_get_preference('resources_max_per_message', mdh_messenger_preferences_section()); ?>"
                                >
                                    <div class="controls">
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-danger btn-xs js-remove-button hidden">
                                                <?php _e("Remove", "madhouse_messenger")?>
                                            </button>
                                        </div>
                                        <input class="js-attachment-file" type="file" name="attachment[]" />
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="clearfix">
                            <?php if (mdh_messenger_resources_enabled()): ?>
                                <a class="btn btn-primary text-white pull-right js-add-attachment">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="13" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg>&nbsp;<?php _e("Add attachment", "madhouse_messenger") ?>
                                </a>
                            <?php endif; ?>
                            <div class="pull-left">
                                <div class="">
                                    <input class="js-submit-message btn btn-primary" type="submit" value="<?php _e("Send message", "madhouse_messenger"); ?>" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php if(mdh_messenger_status_enabled() && (! mdh_messenger_status_for_owner() || (mdh_messenger_status_for_owner() && mdh_is_thread_item_owner()))): ?>
                    <div class="messenger-box status-wrapper messenger-content">
                        <ul class="list-inline">
                            <li><?php _e("Change status to", "madhouse_messenger"); ?></li>
                            <?php while(mdh_has_status()): ?>
                                <?php if(! mdh_thread_has_status() || (mdh_thread_has_status() && mdh_thread_status_id() !== mdh_status_id())): ?>
                                    <li><a class="thread-status thread-status-<?php echo mdh_status_name(); ?>" href="<?php echo mdh_status_url(); ?>"><?php echo mdh_status_title(); ?></a></li>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                        <div class="clear"></div>
                    </div>
                <?php endif; ?>
                <div class="">
                    <ul class="messages list-unstyled js-thread-messages <?php echo (osc_plugin_is_enabled("madhouse_avatar/index.php"))? "messages-with-avatar": ""; ?>"
                        data-has-more                   ="<?php echo(mdh_thread_has_more_messages()); ?>"
                        data-url                        ="<?php echo mdh_messenger_ajax_url(); ?>"
                        data-content-read               ="<?php _e("Read", osc_current_web_theme()); ?>"
                        data-content-delete-action      ="<?php _e("Delete", osc_current_web_theme()); ?>"
                        data-number-per-page            ="<?php echo Params::getParam("n") ?>"
                        data-template-url               ="<?php echo osc_plugin_url(""); ?>madhouse_messenger/views/web/parts/messages.twig"
                        data-thread-id                  ="<?php echo Params::getParam("id"); ?>"
                        data-autolinker-enable          = "<?php echo (osc_get_preference("enable_autolinker", "plugin_madhouse_messenger")); ?>"
                        data-autolinker-new-window      = "<?php echo (osc_get_preference("autolinker_new_window", "plugin_madhouse_messenger")); ?>"
                        data-autolinker-truncate-length = "<?php echo (osc_get_preference("autolinker_truncate_length", "plugin_madhouse_messenger")); ?>"
                        data-autolinker-strip-prefix    = "<?php echo (osc_get_preference("autolinker_strip_prefix", "plugin_madhouse_messenger")); ?>"
                    >
                        <?php while(mdh_has_messages()): ?>
                            <li class="message messenger-box clearfix <?php echo (mdh_message()->isSystem())? "auto-message": ""; ?> <?php echo (mdh_message()->isFromViewer())? "message-sender": ""; ?> <?php echo (mdh_message()->isFromViewer())? "message-sender": ""; ?>">
                                <?php if(!mdh_message()->isSystem() && osc_plugin_is_enabled("madhouse_avatar/index.php")): ?>
                                    <div class="message-avatar-wrapper">
                                        <img class="sender-avatar" src="<?php echo mdh_message()->getSender()->getAvatar() ?>" >
                                    </div>
                                <?php endif; ?>
                                <div class="message-content-wrapper">
                                    <div class="meta message-sent-date pull-right">
                                        <?php echo mdh_message_formatted_sent_date(); ?>
                                    </div>
                                    <?php if(!mdh_message()->isSystem()): ?>
                                        <ul class="list-inline">
                                            <li class="message-title">
                                                <?php if (mdh_message()->getSender()->isRegistered()): ?>
                                                    <a target="_blank" href="<?php echo mdh_message_sender_url(); ?>">
                                                        <?php echo mdh_message_sender_name(); ?>
                                                    </a>
                                                <?php else: ?>
                                                    <?php echo mdh_message_sender_name(); ?>
                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                    <?php endif; ?>
                                    <div class="text js-text">
                                        <?php echo mdh_message_text(); ?>
                                    </div>
                                    <?php if (!mdh_message()->isHidden() && !mdh_message()->isBlocked()): ?>
                                        <?php if (count(mdh_message()->getResources()) > 0): ?>
                                            <div class="messenger-resources clearfix">
                                                <?php foreach (mdh_message()->getResources() as $resource): ?>
                                                    <?php if ($resource->isImage()): ?>
                                                        <a class="fancybox messenger-resource"
                                                           rel="<?php echo mdh_message()->getId() ?>"
                                                           href="<?php echo mdh_messenger_resource_raw_url($resource->getSecret()); ?>"
                                                           style="background-image:url('<?php echo $resource->getThumbnailUrl(); ?>');"
                                                           title="<?php echo osc_esc_html($resource->getOriginalName()); ?>"
                                                        >
                                                        </a>
                                                    <?php else: ?>
                                                        <a class="messenger-resource" href="<?php echo mdh_messenger_resource_raw_url($resource->getSecret()); ?>" target="_blank">
                                                            <span><?php echo osc_esc_html($resource->getOriginalName()); ?></span>
                                                        </a>
                                                    <?php endif ?>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="clearfix">
                                            <?php if (mdh_message()->canDelete()): ?>
                                                <div class="message-delete pull-right">
                                                    <a href="<?php echo mdh_messenger_message_delete_url(mdh_message()->getId(), Params::getParam("secret"), Params::getParam("email")); ?>">
                                                        <?php _e("Delete", "madhouse_messenger"); ?>
                                                    </a>
                                                </div>
                                            <?php endif ?>
                                            <?php if(mdh_message_is_read()): ?>
                                                <div class="message-date">
                                                    <div class="read">
                                                        <?php _e("Read ", "madhouse_messenger"); ?>
                                                            <?php echo mdh_message_formatted_read_date(); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                    <?php if(mdh_thread_has_more_messages()): ?>
                        <div class="ajax-wrapper">
                            <div class="js-thread-loader text-center">
                                <?php _e("Loading previous messages", "madhouse_messenger"); ?>
                            </div>
                            <div class="text-muted text-center js-thread-error-message alert alert-danger" style="display:none">
                            </div>
                            <div class="text-muted text-center js-thread-no-more-message" style="display:none">
                                <span><?php _e("No more message to load", "madhouse_messenger") ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-sm-3 messenger-sidebar">
            <div class="">
                <?php if(mdh_thread_has_status()): ?>
                    <div class="messenger-box  thread-status-wrapper">
                        <h4><?php _e("Status", "madhouse_messenger") ?></h4>
                        <span><div class=" thread-status thread-status-<?php echo mdh_thread_status_name(); ?>"><?php echo mdh_thread_status_title(); ?></div></span>
                    </div>
                <?php endif; ?>
                <div class="messenger-box item messenger-content">
                    <?php if (mdh_thread_had_item()):?>
                        <?php _e("Deleted listing", "madhouse_messenger"); ?>
                    <?php elseif (mdh_thread_has_item() && osc_item_is_expired()): ?>
                        <?php _e("Expired listing", "madhouse_messenger"); ?>
                    <?php elseif (mdh_thread_has_item() && (osc_item_is_spam() || !osc_item_is_enabled())): ?>
                        <?php _e("Spam or blocked listing", "madhouse_messenger"); ?>
                    <?php elseif (mdh_thread_has_item() && !osc_item_is_active()): ?>
                        <?php _e("Deactivated listing", "madhouse_messenger"); ?>
                    <?php elseif (mdh_thread_has_item()): ?>
                            <?php if(osc_has_item_resources()): ?>
                            <a class="item-link" href="<?php echo osc_item_url(); ?>">
                                <div class="item-thumbnail">
                                    <img class="img-responsive" src="<?php echo osc_resource_preview_url(); ?>" />
                                </div>
                            </a>
                            <?php endif; ?>
                            <a class="item-link" href="<?php echo osc_item_url(); ?>">
                                <div class="item-title"><?php echo osc_item_title(); ?></div>
                            </a>
                            <ul class="item-meta list-unstyled">
                                <li><span class="item-price"><?php echo osc_item_formated_price(); ?></span></li>
                                <li><span class="item-location"><?php echo osc_item_city(); ?></span></li>
                            </ul>
                    <?php else: ?>
                        <?php _e("No item linked to this thread", "madhouse_messenger"); ?>
                    <?php endif; ?>
                </div>
                <?php if(
                    (
                        osc_get_preference("enable_block_user", "plugin_madhouse_messenger") &&
                        !mdh_thread()->isGroup() &&
                        osc_is_web_user_logged_in()
                    ) ||
                    (
                        osc_get_preference('subject_edit_enabled', mdh_messenger_preferences_section())
                    )
                ): ?>
                    <div class="messenger-box">
                        <ul class="list-unstyled">
                            <?php if (mdh_thread_can_block()): ?>
                                <?php if (!mdh_thread()->isBlocked()): ?>
                                    <li>
                                        <a class="" href="<?php echo mdh_messenger_block_user_url(mdh_thread()->getId()); ?>">
                                            <?php _e("Block user", "madhouse_messenger"); ?>
                                        </a>
                                    <li>
                                <?php else: ?>
                                    <li>
                                        <a class="" href="<?php echo mdh_messenger_unblock_user_url(mdh_thread()->getId()); ?>">
                                            <?php _e("Unblock user", "madhouse_messenger"); ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if (osc_get_preference('subject_edit_enabled', mdh_current_preferences_section())): ?>
                                <li>
                                    <a class="js-thread-title-edit" href="#">
                                        <?php _e("Edit subject", "madhouse_messenger"); ?>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if (mdh_thread()->getTitle() !=  ""): ?>
                    <div class="messenger-box">
                        <h4><?php _e("Talking with", "madhouse_messenger") ?></h4>
                        <ul class="list-unstyled">
                            <?php foreach (mdh_thread()->getOthers() as $other): ?>
                                <li>
                                    <?php if ($other->isRegistered()): ?>
                                        <a href="<?php echo $other->getUrl() ?>">
                                            <?php echo $other->getName() ?>
                                        </a>
                                    <?php else: ?>
                                        <?php echo $other->getName() ?>
                                    <?php endif ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>

                <?php endif ?>
                <?php if (mdh_thread_resources_count() > 0): ?>
                    <div class="thread-resources messenger-content text-xs">
                        <div class="messenger-box">
                            <span><?php _e("All attachments", "madhouse_messenger") ?></span>
                            <ul class="list-unstyled thread-resources-list">
                                <?php while(mdh_thread_has_resources()): ?>
                                    <li class="text-ellispis">
                                        <a title="<?php echo osc_esc_html(mdh_thread_resource()->getOriginalName()); ?>" <?php echo  (mdh_thread_resource()->isImage())? 'class="fancybox" rel="all"' : ""; ?> href="<?php echo mdh_thread_resource()->getUrl() ?>" target="_blank">
                                            <?php echo osc_esc_html(mdh_thread_resource()->getOriginalName()); ?>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>