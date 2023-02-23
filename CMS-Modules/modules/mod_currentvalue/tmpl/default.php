<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_currentvalue
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

<div id="app_currentvalue<?php echo $attribute_id ?>">
    <current-value
            :parent-component="'module_' + attribute_id"
            :id="attribute_id"
            :live-mode="true"
    ></current-value>
</div>

<script>
    window.onload = () => {
        var app = new core.Vue({
            el: "#app_currentvalue<?php echo $attribute_id ?>",
            data: {
                attribute_id: "<?php echo $attribute_id ?>",
            }
        });
    }
</script>
