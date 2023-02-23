<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_currentvalue
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$attribute_id             = $params->get('attribute_id', '');

require JModuleHelper::getLayoutPath('mod_currentvalue');
