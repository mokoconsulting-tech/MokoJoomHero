<?php

/**
 * @package     MokoConsulting.Module
 * @subpackage  mod_moko_hero
 *
 * @copyright   Copyright (C) 2026 Moko Consulting. All rights reserved.
 * @license     GNU General Public License version 3 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/** @var \Joomla\Registry\Registry $params */
/** @var string $imageUrl */

// Load module stylesheet
HTMLHelper::_('stylesheet', 'mod_moko_hero/mod_moko_hero.css', ['version' => 'auto', 'relative' => true]);

// ── Parameters ────────────────────────────────────────────────────────────────
$moduleId      = 'mod-moko-hero-' . $module->id;
$heroTitle     = $params->get('hero_title', '');
$heroText      = $params->get('hero_text', '');
$link          = trim((string) $params->get('link', ''));
$linkText      = $params->get('link_text', Text::_('MOD_MOKO_HERO_LEARN_MORE'));
$height        = $params->get('height', '70vh');
$overlayOpacity = (float) $params->get('overlay_opacity', 0.45);
$overlayColor  = $params->get('overlay_color', '#000000');
$contentAlign  = $params->get('content_align', 'center');
$textColor     = $params->get('text_color', '#ffffff');
$bgPosition    = $params->get('bg_position', 'center center');

// ── Inline CSS custom properties ───────────────────────────────────────────────
// Passed as CSS variables so the external stylesheet can reference them without
// requiring PHP. This mirrors the approach Cassiopeia uses for dynamic colours.
$inlineStyle = implode(';', array_filter([
    '--moko-hero-height:'          . htmlspecialchars($height,         ENT_QUOTES, 'UTF-8'),
    '--moko-hero-overlay-opacity:' . $overlayOpacity,
    '--moko-hero-overlay-color:'   . htmlspecialchars($overlayColor,   ENT_QUOTES, 'UTF-8'),
    '--moko-hero-text-color:'      . htmlspecialchars($textColor,      ENT_QUOTES, 'UTF-8'),
    '--moko-hero-align:'           . htmlspecialchars($contentAlign,   ENT_QUOTES, 'UTF-8'),
    '--moko-hero-bg-position:'     . htmlspecialchars($bgPosition,     ENT_QUOTES, 'UTF-8'),
    $imageUrl ? '--moko-hero-bg-image:url(' . htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') . ')' : '',
]));

$hasContent = $heroTitle !== '' || $heroText !== '' || $link !== '';
?>
<div
    id="<?php echo $moduleId; ?>"
    class="mod-moko-hero<?php echo $imageUrl ? '' : ' mod-moko-hero--no-image'; ?>"
    style="<?php echo $inlineStyle; ?>"
    role="banner"
    aria-label="<?php echo $heroTitle !== '' ? htmlspecialchars($heroTitle, ENT_QUOTES, 'UTF-8') : Text::_('MOD_MOKO_HERO_ARIA_LABEL'); ?>"
>
    <?php if ($hasContent) : ?>
    <div class="mod-moko-hero__inner container">
        <div class="mod-moko-hero__content">

            <?php if ($heroTitle !== '') : ?>
            <h2 class="mod-moko-hero__title">
                <?php echo htmlspecialchars($heroTitle, ENT_QUOTES, 'UTF-8'); ?>
            </h2>
            <?php endif; ?>

            <?php if ($heroText !== '') : ?>
            <div class="mod-moko-hero__text">
                <?php echo $heroText; ?>
            </div>
            <?php endif; ?>

            <?php if ($link !== '') : ?>
            <a
                href="<?php echo htmlspecialchars($link, ENT_QUOTES, 'UTF-8'); ?>"
                class="mod-moko-hero__cta btn btn-primary btn-lg"
            >
                <?php echo htmlspecialchars($linkText, ENT_QUOTES, 'UTF-8'); ?>
            </a>
            <?php endif; ?>

        </div>
    </div>
    <?php endif; ?>
</div>
