<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_linechart
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('script', 'com_thinkiq/dist/tiq.core.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('script', 'com_thinkiq/dist/tiq.components.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('script', 'com_thinkiq/dist/tiq.charts.js', array('version' => 'auto', 'relative' => true));
?>

<div id="app_linechart<?php echo str_replace(',', '-', $attribute_ids) ?>">
    <duration-picker
            :start-date="start_date"
            :end-date="end_date"
            :show-pan-controls=true
            :show-zoom-controls=true
            @on_date_change="onDateChange"
    ></duration-picker>
    <line-chart
            :ref="'line_chart_' + attribute_ids"
            :line-chart-name="'line_chart_' + attribute_ids"
            :attribute-ids="[attribute_ids]"
            :start-date="start_date"
            :end-date="end_date"
            :title="title"
            :max-num-of-points="max_num_of_points"
            :height="height"
            :show-error=show_errors
            loader_mode="<?php echo $loader_mode ?>"
            :display-mode-bar=<?php echo $display_mode_bar ?>
    ></line-chart>
</div>

<script>
    var app = new core.Vue({
        el: "#app_linechart<?php echo str_replace(',', '-', $attribute_ids) ?>",
        data: {
            attribute_ids: "<?php echo $attribute_ids ?>",
            start_date: "<?php echo $start_date ?>",
            end_date: "<?php echo $end_date ?>",
            title: "<?php echo $title ?? '' ?>",
            max_num_of_points: <?php echo $max_num_of_points ?>,
            height: <?php echo $height ?>,
            show_errors: <?php echo $show_error ?>
        },
        methods:{
            onDateChange: function (start_date, end_date) {
                this.start_date = core.moment(start_date).format("YYYY-MM-DD HH:mm:ss");
                this.end_date = core.moment(end_date).format("YYYY-MM-DD HH:mm:ss");
            }
        },
        mounted() {
            if(!this.start_date || this.start_date == '' || this.start_date == '0000-00-00 00:00:00'){
                this.start_date = core.moment().subtract(1,'h').format("YYYY-MM-DD HH:mm:ss");
            }
            if(!this.end_date || this.end_date == '' || this.end_date == '0000-00-00 00:00:00'){
                this.end_date = core.moment().format("YYYY-MM-DD HH:mm:ss");
            }
        }
    });
</script>
