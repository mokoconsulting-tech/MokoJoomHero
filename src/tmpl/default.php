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
/** @var string $mediaUrl   Root-relative URL to the selected image or video, or '' */
/** @var string $mediaType  'image' | 'video' | '' */

// Load module stylesheet
HTMLHelper::_('stylesheet', 'mod_moko_hero/mod_moko_hero.css', ['version' => 'auto', 'relative' => true]);

// ── Parameters ────────────────────────────────────────────────────────────────
$moduleId       = 'mod-moko-hero-' . $module->id;
$heroTitle      = $params->get('hero_title', '');
$heroText       = $params->get('hero_text', '');
$link           = trim((string) $params->get('link', ''));
$linkText       = $params->get('link_text', Text::_('MOD_MOKO_HERO_LEARN_MORE'));
$height         = $params->get('height', '70vh');
$overlayOpacity = (float) $params->get('overlay_opacity', 0.45);
$overlayColor   = $params->get('overlay_color', '#000000');
$contentAlign   = $params->get('content_align', 'center');
$textColor      = $params->get('text_color', '#ffffff');
$bgPosition     = $params->get('bg_position', 'center center');

$isImage = $mediaType === 'image';
$isVideo = $mediaType === 'video';
$hasMedia = $mediaUrl !== '';

// ── CSS modifier classes ───────────────────────────────────────────────────────
$modifierClasses = [];
if (!$hasMedia)  { $modifierClasses[] = 'mod-moko-hero--no-media'; }
if ($isVideo)    { $modifierClasses[] = 'mod-moko-hero--video'; }

// ── Inline CSS custom properties ───────────────────────────────────────────────
// All configurable visual values travel as CSS variables so the stylesheet
// contains zero hard-coded values for administrator-controlled settings.
$cssVars = [
    '--moko-hero-height:'          . htmlspecialchars($height,       ENT_QUOTES, 'UTF-8'),
    '--moko-hero-overlay-opacity:' . $overlayOpacity,
    '--moko-hero-overlay-color:'   . htmlspecialchars($overlayColor, ENT_QUOTES, 'UTF-8'),
    '--moko-hero-text-color:'      . htmlspecialchars($textColor,    ENT_QUOTES, 'UTF-8'),
    '--moko-hero-align:'           . htmlspecialchars($contentAlign, ENT_QUOTES, 'UTF-8'),
    '--moko-hero-bg-position:'     . htmlspecialchars($bgPosition,   ENT_QUOTES, 'UTF-8'),
];

// Only set the background-image variable for images; videos are DOM elements.
if ($isImage) {
    $cssVars[] = '--moko-hero-bg-image:url(' . htmlspecialchars($mediaUrl, ENT_QUOTES, 'UTF-8') . ')';
}

$inlineStyle = implode(';', $cssVars);

$hasContent = $heroTitle !== '' || $heroText !== '' || $link !== '';

// Derive MIME type for the <video> source element
$videoMime = '';
if ($isVideo) {
    $ext = strtolower(pathinfo($mediaUrl, PATHINFO_EXTENSION));
    $mimeMap = ['mp4' => 'video/mp4', 'webm' => 'video/webm', 'ogg' => 'video/ogg', 'ogv' => 'video/ogg'];
    $videoMime = $mimeMap[$ext] ?? 'video/mp4';
}
?>
<div
    id="<?php echo $moduleId; ?>"
    class="mod-moko-hero<?php echo $modifierClasses ? ' ' . implode(' ', $modifierClasses) : ''; ?>"
    style="<?php echo $inlineStyle; ?>"
    role="banner"
    aria-label="<?php echo $heroTitle !== '' ? htmlspecialchars($heroTitle, ENT_QUOTES, 'UTF-8') : Text::_('MOD_MOKO_HERO_ARIA_LABEL'); ?>"
>
    <?php if ($isVideo) : ?>
    <!--
        Video background — uses an absolutely-positioned <video> element rather
        than CSS background-image (which does not support video).
        autoplay + muted + loop + playsinline are the four attributes required
        for cross-browser autoplay without a user gesture.
        aria-hidden removes the video from the accessibility tree as it is
        purely decorative.
    -->
    <video
        class="mod-moko-hero__video"
        autoplay
        muted
        loop
        playsinline
        aria-hidden="true"
        tabindex="-1"
    >
        <source
            src="<?php echo htmlspecialchars($mediaUrl, ENT_QUOTES, 'UTF-8'); ?>"
            type="<?php echo $videoMime; ?>"
        >
    </video>
    <?php endif; ?>

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
