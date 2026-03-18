<?php

/**
 * @package     MokoConsulting.Module
 * @subpackage  mod_moko_hero
 *
 * @copyright   Copyright (C) 2026 Moko Consulting. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use MokoConsulting\Module\MokoHero\Site\Helper\MokoHeroHelper;

/** @var \Joomla\CMS\Application\SiteApplication $app */
/** @var \Joomla\Registry\Registry $params */

// Resolve a random image or video from the configured folder.
// Returns ['url' => string, 'type' => 'image'|'video'|'']
$media     = MokoHeroHelper::getRandomMedia($params);
$mediaUrl  = $media['url'];
$mediaType = $media['type'];

require ModuleHelper::getLayoutPath('mod_moko_hero', $params->get('layout', 'default'));
