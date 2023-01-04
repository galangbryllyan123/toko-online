<?php

 ?>
 <table border="0" cellspacing="0">
     <tbody>
        <?php while(osc_has_items()) { ?>
            <tr class="row r<?php echo osc_item_id() ; ?> <?php osc_run_hook("highlight_class"); ?>" rel="r<?php echo osc_item_id() ; ?>">
                 <td class="title">
                     <h3><a href="<?php echo osc_item_url() ; ?>"><strong><?php echo osc_item_title() ; ?></strong> <?php echo osc_item_city() ; ?></a></h3>
                 </td>
                 <td class="date"><?php echo osc_format_date( osc_item_pub_date() ) ; ?></td>
                 <td class="see_more"><a href="<?php echo osc_item_url() ; ?>"><?php _e('See job offer', 'masjob') ; ?></a></td>
             </tr>
             <tr class="row r<?php echo osc_item_id() ; ?> <?php osc_run_hook("highlight_class"); ?>" rel="r<?php echo osc_item_id() ; ?>">
                 <td class="description" colspan="3"><?php echo osc_highlight( strip_tags( osc_item_description() ) ) ; ?></td>
             </tr>
        <?php } ?>
    </tbody>
</table>