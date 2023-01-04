<?php

View::newInstance()->_exportVariableToView('seeker_class', 'odd');
?>
<div class="latest_ads ad_list">
<?php if( osc_count_latest_items() == 0) { ?>
   <p class="empty"><?php _e('There aren\'t job offers available at this moment', 'seeker'); ?></p>
<?php } else { ?>
   <table>
        <thead>
            <tr>
                <th><?php _e('Vacancy', 'seeker') ; ?></th>
                <th><?php _e('Location', 'seeker') ; ?></th>
                <th><?php _e('Date', 'seeker') ; ?></th>
            </tr>
       </thead>
       <tbody>
       <?php while ( osc_has_latest_items() ) { ?>
           <?php osc_current_web_theme_path('inc.grid.php') ; ?>
       <?php } ?>
       </tbody>
    </table>
    <?php if( osc_count_latest_items() == osc_max_latest_items() ) { ?>
        <p class="see_more_link"><a href="<?php echo osc_search_show_all_url() ; ?>">
            <strong><?php _e('See all ads', 'seeker') ; ?> &raquo;</strong></a>
        </p>
    <?php } ?>
<?php } ?>
</div>