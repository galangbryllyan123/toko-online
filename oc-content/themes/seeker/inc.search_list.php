<?php

     //osc_set_preference('maxLatestItems@home',5,'osclass');
View::newInstance()->_exportVariableToView('seeker_class', 'odd');
?>
<h1><strong><?php _e('Search results', 'seeker') ; ?></strong></h1>

<div class="ad_list">
<?php if( osc_count_latest_items() == 0) { ?>
    <p class="empty"><?php printf(__('There are no results matching "%s"', 'seeker'), osc_search_pattern()) ; ?></p>
<?php } else { ?>
    <table id="table">
        <thead>
            <tr>
                <th><?php _e('Vacancy', 'seeker') ; ?></th>
                <th><?php _e('Location', 'seeker') ; ?></th>
                <th><?php _e('Date', 'seeker') ; ?></th>
            <tr>
        </thead>
        <tbody>
            <?php while ( osc_has_items() ) { ?>
                <?php osc_current_web_theme_path('inc.grid.php') ; ?>
            <?php } ?>
        </tbody>
   </table>
   <div class="paginate" >
        <?php echo osc_search_pagination(); ?>
    </div>
<?php } ?>
</div>