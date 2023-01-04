<?php

if(!defined('OC_ADMIN')):
    exit('Direct access is not allowed.');
endif;

?>
<?php require __DIR__ . "/nav.php"; ?>
<div class="dashboard bg-light">
    <div class="container-fluid">
        <?php if(! mdh_get_preference("version")): ?>
            <div class="space-in">
                <h2 class="h4 space-in-sm row-space-2">
                    <?php _e("Upgrade", mdh_current_plugin_name()); ?>
                </h2>
                <div class="alert alert-warning text-center">
                    <?php _e("Your messenger plugin needs to be upgraded.", mdh_current_plugin_name()); ?>&nbsp;
                    <a class="btn btn-info" href="<?php echo mdh_messenger_admin_upgrade_url(); ?>">
                        <?php _e("Upgrade now!", mdh_current_plugin_name()); ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            // Load the Visualization API and the corechart package.
            google.charts.load('current', {'packages':['line']});
            google.charts.setOnLoadCallback(drawChart);

            options = {
                height: 293,
                chart: {
                  title: '<?php echo osc_esc_js(__('Thread and messages statistics', mdh_current_plugin_name())); ?>',
                  subtitle: '<?php echo osc_esc_js(sprintf(__('in the last %s %s', mdh_current_plugin_name()), Params::getParam('period'), Params::getParam('type'))); ?>'
                }
            };

            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', '<?php echo osc_esc_js(Params::getParam('type')); ?>');
                data.addColumn('number', '<?php echo osc_esc_js(__('Messages', mdh_current_plugin_name())); ?>');
                data.addColumn('number', '<?php echo osc_esc_js(__('Threads', mdh_current_plugin_name())); ?>');

                <?php
                $messages = __get("charts_messages");
                $threads = __get("charts_threads");;
                $k = 0;
                echo "data.addRows(" . count($messages) . ");";
                foreach($messages as $date => $num) {
                    echo "data.setValue(" . $k . ', 0, "' . $date . '");';
                    echo "data.setValue(" . $k . ", 1, " . $num . ");";
                    echo "data.setValue(" . $k . ", 2, " . $threads[$date] . ");";
                    $k++;
                }
                $k = 0;
                ?>


                // Instantiate and draw our chart, passing in some options.
                var chart = new google.charts.Line(document.getElementById('stats-messages'));
                chart.draw(data, google.charts.Line.convertOptions(options));

            }
        </script>
        <div class="space-in">
            <div class="row-space-3">
                <form class="form-inline nocsrf" action="<?php echo mdh_messenger_admin_dashboard_url() ?>" method="GET">
                    <input type="hidden" name="page" value="plugins">
                    <input type="hidden" name="action" value="renderplugin">
                    <input type="hidden" name="route" value="madhouse_messenger_dashboard">
                    <div class="form-group">
                        <label class="control-label"> <?php _e("Filters", mdh_current_plugin_name()) ?></label>
                    </div>
                    <div class="form-group">
                        <select name="type">
                            <option value="day" <?php echo (Params::getParam("type") == "day") ? 'selected="selected"' : "" ?>>
                                <?php _e("Daily", mdh_current_plugin_name()) ?>
                            </option>
                            <option value="week" <?php echo (Params::getParam("type") == "week") ? 'selected="selected"' : "" ?>>
                                <?php _e("Weekly", mdh_current_plugin_name()) ?>
                            </option>
                            <option value="month" <?php echo (Params::getParam("type") == "month") ? 'selected="selected"' : "" ?>>
                                <?php _e("Monthly", mdh_current_plugin_name()) ?>
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label"> <?php _e("Period", mdh_current_plugin_name()) ?></label>
                    </div>
                    <div class="form-group">
                        <input style="width: 50px" class="form-control" type="text" name="period" value="<?php echo osc_esc_html(Params::getParam("period")) ?>"/>
                    </div>
                    <button class="btn btn-primary">
                        <?php _e("Filter", mdh_current_plugin_name()) ?>
                    </button>
                </form>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <div class="panel bg-light">
                        <div class="lter panel-heading space-in-md">
                            <h3 class="h4 row-space-0">
                                <?php printf(__("Stats by %s", mdh_current_plugin_name()), Params::getParam("type")); ?>
                            </h3>
                        </div>
                        <div class="panel-body bg-info space-in-md lt">
                            <div class="">
                                <h4 class="h5 row-space-3">
                                    <?php if (Params::getParam("type") == "day"): ?>
                                        <?php _e("Today", mdh_current_plugin_name()); ?>
                                    <?php elseif (Params::getParam("type") == "week"): ?>
                                        <?php printf(__("This week", mdh_current_plugin_name())); ?>
                                    <?php else: ?>
                                        <?php printf(__("This month", mdh_current_plugin_name())); ?>
                                    <?php endif ?>
                                </h4>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <span class="h1 font-bold text-white row-space-0">
                                            <?php echo __get('threads_count_current'); ?>
                                        </span>
                                        <span class="text-muted">
                                            <?php _e("threads", mdh_current_plugin_name()); ?>
                                        </span>
                                    </div>
                                    <div class="col-xs-6">
                                        <span class="h1 font-bold text-white row-space-0">
                                            <?php echo __get('messages_count_current'); ?>
                                        </span>
                                        <span class="text-muted">
                                            <?php _e("messages", mdh_current_plugin_name()); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body bg-info dk space-in-md">
                            <div class="">
                                <h4 class="h5 row-space-3">
                                    <?php if (Params::getParam("type") == "day"): ?>
                                        <?php _e("Yesterday", mdh_current_plugin_name()); ?>
                                    <?php elseif (Params::getParam("type") == "week"): ?>
                                        <?php printf(__("Last week", mdh_current_plugin_name())); ?>
                                    <?php else: ?>
                                        <?php printf(__("Last month", mdh_current_plugin_name())); ?>
                                    <?php endif ?>
                                </h4>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <span class="h1 font-bold text-white row-space-0">
                                            <?php echo __get('threads_count_last'); ?>
                                        </span>
                                        <span class="text-muted">
                                            <?php _e("threads", mdh_current_plugin_name()); ?>
                                        </span>
                                    </div>
                                    <div class="col-xs-6">
                                        <span class="h1 font-bold text-white row-space-0">
                                            <?php echo __get('messages_count_last'); ?>
                                        </span>
                                        <span class="text-muted">
                                            <?php _e("messages", mdh_current_plugin_name()); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class="panel" style="height: 324px">
                        <div class="panel-body">
                            <div id="stats-messages" class="graph"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="panel bg-light">
                        <div class=" panel-heading lt space-in-md b-0">
                            <h3 class="h4 row-space-0"><?php _e("All time", mdh_current_plugin_name()); ?></h3>
                        </div>
                        <div class="panel-body bg-info lter space-in-md">
                            <h4 class="h5 row-space-3"><?php _e("Since the beginning", mdh_current_plugin_name()); ?>&nbsp;:</h4>
                            <div class="row">
                                <div class="col-xs-6">
                                    <span class="h1 font-bold row-space-0">
                                        <?php echo mdh_messenger_threads_count(); ?>
                                    </span>
                                    <span class="text-muted">
                                        <?php _e("threads", mdh_current_plugin_name()); ?>
                                    </span>
                                </div>
                                <div class="col-xs-6">
                                    <span class="h1 font-bold row-space-0">
                                        <?php echo mdh_messenger_messages_count(); ?>
                                    </span>
                                    <span class="text-muted">
                                        <?php _e("messages", mdh_current_plugin_name()); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="panel bg-light">
                        <div class=" panel-heading lt space-in-md b-0">
                            <h3 class="h4 row-space-0"><?php printf(__("Top users last %s %ss", mdh_current_plugin_name()), Params::getParam('period'), Params::getParam("type")); ?></h3>
                        </div>
                        <?php $users = __get("stats_users"); ?>
                        <?php if (count($users) == 0): ?>
                            <div class="panel-body">
                                <span class="text-muted"><?php _e("Any user for this period", mdh_current_plugin_name()) ?></span>
                            </div>
                        <?php else: ?>
                            <ul class="list-group row-space-0" style="max-height: 200px; overflow:scroll">
                                <?php foreach ($users as $key => $result) : ?>

                                    <li class="list-group-item">
                                        <span class="badge bg-info"><?php echo $result['num'] ?></span>
                                        <a target="_blank" href="<?php echo osc_admin_base_url(true) ?>?page=users&amp;userId=<?php $result['user']->getId()  ?>&amp;user=<?php echo $result['user']->getName() ?>">
                                            <?php echo ($result['user']->isRegistered()) ? $result['user']->getName() : $result['user']->getEmail()?>
                                        </a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="panel bg-light">
                        <div class=" panel-heading lt space-in-md b-0">
                            <h3 class="h4 row-space-0"><?php printf(__("Top listings last %s %ss", mdh_current_plugin_name()), Params::getParam('period'), Params::getParam("type")); ?></h3>
                        </div>
                        <?php $items = __get("stats_items"); ?>
                        <?php if (count($items) == 0): ?>
                            <div class="panel-body">
                                <span class="text-muted"><?php _e("Any listing for this period", mdh_current_plugin_name()) ?></span>
                            </div>
                        <?php else: ?>
                            <ul class="list-group row-space-0" style="max-height: 200px; overflow:scroll">
                                <?php foreach ($items as $key => $result) : ?>
                                    <li class="list-group-item">
                                        <span class="badge bg-info"><?php echo $result['num'] ?></span>
                                        <a target="_blank" href="<?php echo osc_admin_base_url(true) ?>?page=items&amp;shortcut-filter=oItemId&amp;itemId=<?php echo $result['item']->getId()  ?>">
                                            <?php echo $result['item']->getTitle() ?>
                                        </a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>