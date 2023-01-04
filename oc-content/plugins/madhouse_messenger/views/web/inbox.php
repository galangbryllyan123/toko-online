<?php

/*
 * ========================================================================================
 *
 * TO CUSTOMIZE
 *
 * COPY THIS FILE TO YOUR THEME IN
 * oc-content/themes/{your_theme_name}/plugins/madhouse_messenger/inbox.php
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

<?php

    $params = array(
        'total'              => (int) ceil(mdh_count_threads() / Params::getParam("n")),
        'selected'           => (int) Params::getParam("p") - 1,
        'class_prev'         => 'prev',
        'class_next'         => 'next',
        'class_selected'     => 'active',
        'url'                => mdh_messenger_inbox_url(
            array(
                "label" => Params::getParam("label"),
                "item" => Params::getParam("item"),
                "filter" => Params::getParam("filter")
            ),
            '{PAGE}',
            Params::getParam("n")
        )
    );
    $pagination = new Pagination($params);
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#js-listing-user-filter').bind('change', function(e) {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
              window.location = url; // redirect
            }
            return false;
        });
    });
</script>

<link rel="stylesheet" type="text/css" href="<?php echo osc_plugin_url(""); ?>madhouse_messenger/assets/css/web.css" />
<div class="messenger">
    
<style>
.dropbtn {
    
    background-color: #03a9f4;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    margin-top:20px;
    width:100%;
    cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
    background-color: #2980B9;
    
}

.dropdown {
    position: relative;
    display: inline-block;
    width:100%;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    width:100%;
    margin-top:70px;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    width:100%;
}

.dropdown a:hover {width:100%;background-color: #ddd}

.show {display:block;}
</style>
</head>
<body>


<div class="dropdown">
<button onclick="myFunction()" class="dropbtn">Messenger</button>
  <div id="myDropdown" class="dropdown-content">
    
    <a href="?&label=inbox">Inbox</a>
    <a href="?&label=archive">Archive</a>
    <a href="?&label=trash">Trash</a>

  </div>
</div>

<script>
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}
</script>
    
    <div>
        <div class="clearfix messenger-pagination">
           
            <div class="pull-right">
                <?php
                    $params = array(
                        "label" => Params::getParam("label")
                    );
                ?>
                <select name="filters" id="js-listing-user-filter">
                    <option value=""><?php _e("Filter : ", "madhouse_messenger") ?></option>
                    <?php while (osc_has_items()): ?>
                        <option
                            value="<?php echo mdh_messenger_inbox_url(array_merge($params, array("item" => osc_item_id()))); ?>"
                            <?php echo (Params::getParam('item') == osc_item_id()) ? 'selected="selected"' : "" ?>
                        >
                            <?php printf(__(" %s", "madhouse_messenger"), osc_item_title()) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
        <?php if(mdh_count_threads()): ?>
            <ul class="list-unstyled threads">
                <?php while(mdh_has_threads()): ?>
                    <li class="panel-body thread messenger-content <?php echo (mdh_thread_has_unread()) ? "has-unread": ""; ?>">
                        <div class="row pos-relative ">
                            <div class="col-xs-8  col-sm-2 thread-author">
                                <div class="thread-name text-ellipsis">
                                    <?php echo mdh_thread_title_default(); ?>
                                    <?php if(mdh_thread_has_unread()): ?>
                                            &nbsp;<strong>(<?php echo mdh_thread_count_unread() ?>)</strong>
                                    <?php endif; ?>
                                </div>
                                <div class="text-ellipsis thread-date">
                                    <?php echo mdh_thread_formatted_last_activity(); ?>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-sm-push-7 thread-label">
                                <ul class="pull-right list-inline text-right">
                                    <?php if(mdh_thread_has_item()): ?>
                                       <li class="hidden-xs">
                                            <span class="thread-price">
                                                <?php echo osc_item_formated_price(); ?>
                                            </span>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(mdh_thread_has_status()): ?>
                                    <li class="">
                                        <span class="thread-status thread-status-<?php echo mdh_thread_status_name(); ?>">
                                        <?php echo mdh_thread_status_title(); ?>
                                        </span>
                                    </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-7 col-sm-pull-3 thread-body">
                                <a href="<?php echo mdh_thread_url(); ?>" class="thread-link text-muted">
                                    <div class="thread-subject text-ellipsis">
                                        <?php echo mdh_thread_excerpt(); ?>
                                    </div>
                                    <div class="thread-item text-ellipsis visible-lg-block">
                                        <?php if (mdh_thread_had_item()):?>
                                            <?php _e("Deleted listing", "madhouse_messenger"); ?>
                                        <?php elseif (mdh_thread_has_item() && osc_item_is_expired()): ?>
                                            <?php _e("Expired listing", "madhouse_messenger"); ?>
                                        <?php elseif (mdh_thread_has_item() && (osc_item_is_spam() || !osc_item_is_enabled())): ?>
                                            <?php _e("Spam or blocked listing", "madhouse_messenger"); ?>
                                        <?php elseif (mdh_thread_has_item() && !osc_item_is_active()): ?>
                                            <?php _e("Deactivated listing", "madhouse_messenger"); ?>
                                        <?php elseif (mdh_thread_has_item()): ?>
                                                <?php if(osc_item_city() != ""): ?>
                                                    <?php printf("%s - %s", osc_item_title(), osc_item_city()); ?>
                                                <?php else: ?>
                                                    <?php echo osc_item_title(); ?>
                                                <?php endif; ?>
                                        <?php else: ?>
                                            <?php _e("No item linked to this thread", "madhouse_messenger"); ?>
                                        <?php endif; ?>
                                    </div>
                                </a>
                                <ul class="thread-actions list-inline">
                                    <?php if(mdh_messenger_is_inbox_page()): ?>
                                        <li>
                                            <a href="<?php echo mdh_messenger_thread_archive_url(mdh_thread_id()); ?>">
                                                <?php _e("Archive", "madhouse_messenger"); ?>
                                            </a>
                                        </li>
                                    <?php elseif(mdh_messenger_is_archive_page()): ?>
                                        <li>
                                            <a href="<?php echo mdh_messenger_thread_unarchive_url(mdh_thread_id()); ?>">
                                                <?php _e("Move to inbox", "madhouse_messenger"); ?>
                                            </a>
                                        </li>
                                    <?php endif;?>
                                    <?php if(mdh_messenger_is_trash_page()): ?>
                                        <li>
                                            <a href="<?php echo mdh_messenger_thread_restore_url(mdh_thread_id()); ?>">
                                                <?php _e("Restore", "madhouse_messenger"); ?>
                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <a href="<?php echo mdh_messenger_thread_delete_url(mdh_thread_id()); ?>">
                                                <?php _e("Delete", "madhouse_messenger"); ?>
                                            </a>
                                        </li>
                                    <?php endif;?>
                                    <?php while(mdh_has_thread_labels()): ?>
                                        <?php if(!mdh_thread_label_is_system()): ?>
                                            <?php if (!mdh_thread_in_label(mdh_thread_label())): ?>
                                                <li>
                                                    <a href="<?php echo mdh_messenger_thread_label_add_url(mdh_thread_id(), mdh_thread_label_id()); ?>">
                                                        <?php _e("Mark as", "madhouse_messenger"); ?>&nbsp;<?php echo mdh_thread_label_title(); ?>
                                                    </a>
                                                </li>
                                            <?php else: ?>
                                                <li>
                                                    <a href="<?php echo mdh_messenger_thread_label_remove_url(mdh_thread_id(), mdh_thread_label_id()); ?>">
                                                        <?php _e("Unmark as", "madhouse_messenger"); ?>&nbsp;<?php echo mdh_thread_label_title(); ?>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                    <?php if(
                                        osc_get_preference("enable_mark_as_unread", "plugin_madhouse_messenger") &&
                                        !mdh_thread()->getLastMessage()->isFromViewer() &&
                                        !mdh_thread()->hasUnreadMessages()
                                    ): ?>
                                        <li>
                                            <a href="<?php echo mdh_messenger_thread_mark_unread_url(mdh_thread_id()); ?>">
                                                <?php _e("Mark as unread", "madhouse_messenger"); ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if(mdh_thread_can_block()): ?>
                                        <?php if(!mdh_thread()->isAlone() && !mdh_thread()->isBlocked()): ?>
                                            <li>
                                                <a href="<?php echo mdh_messenger_block_user_url(mdh_thread()->getId()); ?>">
                                                    <?php _e("Block", "madhouse_messenger"); ?>
                                                </a>
                                            </li>
                                        <?php elseif (!mdh_thread()->isAlone()): ?>
                                               <li>
                                                <a href="<?php echo mdh_messenger_unblock_user_url(mdh_thread()->getId()); ?>">
                                                    <?php _e("Unblock", "madhouse_messenger"); ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
            <div class="pull-right">
                <div class="pagination">
                    <?php echo $pagination->doPagination(); ?>
                </div>
                <div class="showing-results">
                    <?php echo mdh_pagination_from(Params::getParam("p"), Params::getParam("n")); ?>
                    &nbsp;&ndash;&nbsp;
                    <?php echo mdh_pagination_to(Params::getParam("p"), Params::getParam("n"), mdh_count_threads()); ?>
                    &nbsp;<?php _e("on", "madhouse_messenger"); ?>&nbsp;
                    <?php echo mdh_count_threads(); ?>
                </div>
            </div>
        <?php else: ?>
            <p style="text-align: center; font-size: 1.2em; color: #666;">
                <?php if (Params::getParam("filter") == "unread") : ?>
                    <?php if (Params::getParam("item") != "") : ?>
                        <?php printf(__("No message unread for listing '%s' iha %s", "madhouse_messenger"), mdh_current_item()->getTitle(), strtolower(mdh_current_label()->getName())); ?>
                    <?php else : ?>
                        <?php printf(__("No message unread in %s, yet.", "madhouse_messenger"), strtolower(mdh_current_label()->getName())); ?>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if (Params::getParam("item") != "") : ?>
                        <?php printf(__("No message for listing '%s' in %s", "madhouse_messenger"), mdh_current_item()->getTitle(), strtolower(mdh_current_label()->getName())); ?>
                    <?php else : ?>
                        <?php printf(__("No message in inbox, yet.", "madhouse_messenger"), strtolower(mdh_current_label()->getName())); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>
</div>
