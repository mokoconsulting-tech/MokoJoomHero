<?php

/**
 * @package     MokoConsulting.Module
 * @subpackage  mod_moko_hero
 *
 * @copyright   Copyright (C) 2026 Moko Consulting. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */

namespace MokoConsulting\Module\MokoHero\Site\Dispatcher;

defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use MokoConsulting\Module\MokoHero\Site\Helper\MokoHeroHelper;

/**
 * Dispatcher for mod_moko_hero.
 *
 * Resolves the display mode and populates layout variables via getLayoutData(),
 * following the same pattern as Joomla's own mod_random_image dispatcher.
 */
class Dispatcher extends AbstractModuleDispatcher
{
    /**
     * Returns the layout data array passed into the template.
     *
     * @return  array
     */
    protected function getLayoutData(): array
    {
        $data   = parent::getLayoutData();
        $params = $data['params'];
        $helper = new MokoHeroHelper();

        $displayMode = $params->get('display_mode', 'random');

        if ($displayMode === 'slideshow') {
            $data['slides']    = $helper->getAllMedia($params);
            $data['mediaUrl']  = '';
            $data['mediaType'] = '';
        } else {
            $data['slides']    = [];
            $media             = $helper->getRandomMedia($params);
            $data['mediaUrl']  = $media['url']  ?? '';
            $data['mediaType'] = $media['type'] ?? '';
        }

        $data['displayMode'] = $displayMode;

        return $data;
    }
}
