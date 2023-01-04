<?php

$class = __get('seeker_class');
View::newInstance()->_exportVariableToView('seeker_class', $class=='odd'?'even':'odd');
?>
<tr class="<?php osc_run_hook("highlight_class"); ?> <?php echo $class; ?>">
<td class="title">
<strong><a href="<?php echo osc_item_url() ; ?>"><?php echo osc_item_title() ; ?></a></strong>
</td>
<td class="location">
<strong><?php echo osc_item_city() ; ?></strong>
</td>
<td class="date"><?php echo osc_format_date(osc_item_pub_date() ) ; ?></td>
</tr>
<tr class="<?php osc_run_hook("highlight_class"); ?> <?php echo $class; ?> description">
<td colspan="3"><?php echo strip_tags(osc_highlight( osc_item_description(), 250)) ; ?></td>
</tr>