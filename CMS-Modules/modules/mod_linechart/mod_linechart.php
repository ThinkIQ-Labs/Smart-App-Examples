<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_linechart
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$attribute_ids            = $params->get('attribute_ids', '');
$start_date               = $params->get('start_date', '');
$end_date                 = $params->get('end_date', '');
$title                    = $params->get('title', '');
$max_num_of_points        = $params->get('max_num_of_points', '1000');
$height                   = $params->get('height', 450);
$show_error               = $params->get('show_error', 'false');
$loader_mode              = $params->get('loader_mode', 'Small');
$display_mode_bar         = $params->get('display_mode_bar', 'false');
$display_duration_picker  = $params->get('display_duration_picker', 0);

require JModuleHelper::getLayoutPath('mod_linechart');
