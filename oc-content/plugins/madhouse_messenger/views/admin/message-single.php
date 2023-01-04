<tr class="<?php echo (mdh_message()->isBlocked())?"status-inactive":"status-active"; ?>">
    <td class="col-status-border"></td>
    <td class="col-status"><?php echo (mdh_message()->isBlocked())?_e("Blocked", mdh_current_plugin_name()):_e("Active", mdh_current_plugin_name()); ?></td>
    <td class="col-bulkactions">
        <input type="checkbox" name="id[]" value="<?php echo mdh_message()->getId() ?>" />
        <div class="actions">
            <ul>
                <li><a href="<?php echo mdh_messenger_admin_messages_url("oThread") ?>"><?php _e("Show thread", mdh_current_plugin_name()) ?></a></li>
                <?php if (mdh_message()->getThread()->hasItem()): ?>
                    <li><a href="<?php echo mdh_messenger_admin_messages_url("oItem") ?>"><?php _e("Show messages of item", mdh_current_plugin_name()) ?>&nbsp;<?php echo mdh_message()->getThread()->getItem()->getId() ?></a></li>
                <?php endif; ?>
                <li class="show-more">
                    <a href="#" class="show-more-trigger"><?php _e("Show more...", mdh_current_plugin_name()) ?></a>
                    <ul>
                        <li><a href="<?php echo mdh_messenger_admin_messages_url("oUser") ?>"><?php _e("Show messages of", mdh_current_plugin_name()) ?> <?php echo mdh_message()->getSender()->getName() ?></a></li>
                        <li>
                            <?php if (mdh_message()->isBlocked()): ?>
                                <a href="<?php echo mdh_messenger_admin_unblock_url(mdh_message_id()) ?>">
                                    <?php _e("Unblock", mdh_current_plugin_name()) ?>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo mdh_messenger_admin_block_url(mdh_message_id()) ?>">
                                    <?php _e("Block", mdh_current_plugin_name()) ?>
                                </a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </td>
    <td>
        <strong><?php _e("From: ", mdh_current_plugin_name()) ?></strong>
        <br />
        <?php if (mdh_message()->getSender()->isRegistered()): ?>
            <a href="<?php echo osc_admin_base_url(true) ?>?page=users&amp;userId=<?php echo mdh_message()->getSender()->getId()  ?>&amp;user=<?php echo mdh_message()->getSender()->getName() ?>" target="_blank">
                <?php echo mdh_message()->getSender()->getName() ?>&nbsp;(@<?php echo mdh_message()->getSender()->getUsername() ?>)
            </a>
        <?php else: ?>
            <?php echo mdh_message()->getSender()->getName(); ?>
                <?php if (!mdh_message()->getSender()->isDeleted()): ?>
                    &nbsp;(<?php echo mdh_message()->getSender()->getEmail() ?>)
                    <a target="_blank" href="<?php echo mdh_messenger_thread_url(mdh_message()->getThread()->getId(), mdh_message()->getThread()->getSecret(), mdh_message()->getSender()->getEmail()); ?>">
                        <i class="glyphicon glyphicon-comment"></i>
                    </a>
                <?php endif; ?>
        <?php endif; ?>
        <br />
        <strong><?php _e("To: ", mdh_current_plugin_name()) ?></strong>
        <br />
        <?php foreach (mdh_message()->getRecipients() as $recipient):?>
            <?php if ($recipient->isRegistered()): ?>
                <a href="<?php echo osc_admin_base_url(true) ?>?page=users&amp;userId=<?php $recipient->getId()  ?>&amp;user=<?php echo $recipient->getName() ?>" target="_blank">
                    <?php echo $recipient->getName() ?>&nbsp;(@<?php echo $recipient->getUsername() ?>)
                </a>
            <?php else: ?>
                <?php echo $recipient->getName(); ?>
                <?php if (!$recipient->isDeleted()): ?>
                    &nbsp;(<?php echo $recipient->getEmail() ?>)
                    <a target="_blank" href="<?php echo mdh_messenger_thread_url(mdh_message()->getThread()->getId(), mdh_message()->getThread()->getSecret(), $recipient->getEmail()); ?>">
                        <i class="glyphicon glyphicon-comment"></i>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </td>
    <td>
        <div>
            <?php if (mdh_message()->isAuto()) : ?>
                <span class="label label-primary space-out-r-xs"><?php _e("Auto-message", mdh_current_plugin_name()) ?></span>
            <?php endif; ?>
            <?php echo mdh_message()->getText(); ?>
        </div>
        <div>
            <?php if (count(mdh_message()->getResources()) > 0): ?>
                <div class="space-out-t">
                    <span class="font-bold"><?php _e("Message attachments: ", mdh_current_plugin_name()); ?></span>
                    <ul class="list-unstyled">
                        <?php foreach (mdh_message()->getResources() as $resource): ?>
                            <li>
                                <a class="messenger-resource" href="<?php echo mdh_messenger_resource_raw_url($resource->getSecret()); ?>" target="_blank">
                                    <span><?php echo osc_esc_html($resource->getOriginalName()); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </td>
    <td>
        <?php if (mdh_message()->getThread()->hasItem()): ?>
            <a href="<?php echo osc_admin_base_url(true) ?>?page=items&amp;shortcut-filter=oItemId&amp;itemId=<?php echo mdh_message()->getThread()->getItem()->getId()  ?>" target="_blank">
                <?php echo mdh_message()->getThread()->getItem()->getTitle() ?>
            </a><br />
            <?php if (mdh_message()->getThread()->getItem()->isSpam()): ?>
                <span class="label label-danger"><?php _e("Spam", mdh_current_plugin_name()) ?></span>
            <?php elseif (!mdh_message()->getThread()->getItem()->isEnabled()): ?>
                <span class="label label-danger"><?php _e("Blocked", mdh_current_plugin_name()) ?></span>
            <?php elseif (!mdh_message()->getThread()->getItem()->isActive()): ?>
                <span class="label label-danger"><?php _e("Disabled", mdh_current_plugin_name()) ?></span>
            <?php endif; ?>
        <?php elseif (mdh_message()->getThread()->hadItem()): ?>
            <span class="text-muted"><?php _e("Deleted", mdh_current_plugin_name()) ?></span>
        <?php else: ?>
            -
        <?php endif; ?>
    </td>
    <td><?php echo mdh_message()->getFormattedSentDate(); ?></td>
</tr>