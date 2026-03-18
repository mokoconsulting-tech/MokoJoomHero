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
use MokoConsulting\Module\MokoHero\Helper\MokoHeroHelper;

/** @var \Joomla\CMS\Application\SiteApplication $app */
/** @var \Joomla\Registry\Registry $params */

$displayMode = $params->get('display_mode', 'random');

if ($displayMode === 'slideshow') {
    // Slideshow: pass the full list of media items to the template.
    $slides    = MokoHeroHelper::getAllMedia($params);
    $mediaUrl  = '';
    $mediaType = '';
} else {
    // Random: pick a single item.
    $slides    = [];
    $media     = MokoHeroHelper::getRandomMedia($params);
    $mediaUrl  = $media['url']  ?? '';
    $mediaType = $media['type'] ?? '';
}

require ModuleHelper::getLayoutPath('mod_moko_hero', $params->get('layout', 'default'));
