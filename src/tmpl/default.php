<?php

/**
 * @package     MokoConsulting.Module
 * @subpackage  mod_moko_hero
 *
 * @copyright   Copyright (C) 2026 Moko Consulting. All rights reserved.
 * @license     GNU General Public License version 3 or later
 *
 * Layout mirrors the Cassiopeia mod_custom "banner" override structure:
 *
 *   <div class="container-banner [mod-moko-hero--*]" …>   ← outer / bg layer
 *     <div class="banner-overlay">                         ← content panel
 *       <div class="mod-moko-hero__text1">…</div>          ← WYSIWYG level 1
 *       <div class="mod-moko-hero__text2">…</div>          ← WYSIWYG level 2
 *       <div class="mod-moko-hero__text3">…</div>          ← WYSIWYG level 3
 *       <div class="mod-moko-hero__buttons">               ← up to 3 buttons
 *         <a class="btn …">…</a>
 *       </div>
 *     </div>
 *   </div>
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

/**
 * Variables provided by mod_moko_hero.php:
 * @var \Joomla\Registry\Registry    $params
 * @var \Joomla\CMS\Object\CMSObject $module
 * @var string  $displayMode   'random' | 'slideshow'
 * @var string  $mediaUrl      Root-relative URL (random mode) or ''
 * @var string  $mediaType     'image' | 'video' | ''
 * @var array   $slides        Full media list (slideshow mode) or []
 */

HTMLHelper::_('stylesheet', 'mod_moko_hero/mod_moko_hero.css', ['version' => 'auto', 'relative' => true]);

// ── Parameters ────────────────────────────────────────────────────────────────
$moduleId        = 'mod-moko-hero-' . $module->id;
$height          = $params->get('height', '70vh');
$overlayOpacity  = (float) $params->get('overlay_opacity', 0.45);
$overlayColor    = $params->get('overlay_color', '#000000');
$contentAlign    = $params->get('content_align', 'center');
$textColor       = $params->get('text_color', '#ffffff');
$bgPosition      = $params->get('bg_position', 'center center');
$slideDuration   = (int) $params->get('slide_duration', 5);
$slideTransition = (float) $params->get('slide_transition', 1.0);

// ── Text levels (WYSIWYG) ─────────────────────────────────────────────────────
$text1 = trim((string) $params->get('text1', ''));
$text2 = trim((string) $params->get('text2', ''));
$text3 = trim((string) $params->get('text3', ''));

// ── Buttons — collected when a label is present ───────────────────────────────
// icon is a FontAwesome class string (e.g. "fas fa-arrow-right"); rendered as
// <i class="..." aria-hidden="true"></i> before the label text.
$buttons = [];
foreach ([1, 2, 3] as $n) {
    $label = trim((string) $params->get('btn' . $n . '_label', ''));
    if ($label === '') {
        continue;
    }
    $buttons[] = [
        'label' => $label,
        'icon'  => trim((string) $params->get('btn' . $n . '_icon',  '')),
        'url'   => trim((string) $params->get('btn' . $n . '_url',   '')),
        'style' => $params->get('btn' . $n . '_style', 'btn-primary'),
    ];
}

// ── Media / display mode ──────────────────────────────────────────────────────
$isSlideshow = $displayMode === 'slideshow';
$isImage     = $mediaType === 'image';
$isVideo     = $mediaType === 'video';
$hasMedia    = $mediaUrl !== '' || !empty($slides);
$hasContent  = $text1 !== '' || $text2 !== '' || $text3 !== '' || !empty($buttons);

// ── Root element classes ──────────────────────────────────────────────────────
$modClasses = ['container-banner', 'mod-moko-hero'];
if (!$hasMedia)   { $modClasses[] = 'mod-moko-hero--no-media'; }
if ($isVideo)     { $modClasses[] = 'mod-moko-hero--video'; }
if ($isSlideshow) { $modClasses[] = 'mod-moko-hero--slideshow'; }

// ── Inline CSS custom properties ───────────────────────────────────────────────
$cssVars = [
    '--moko-hero-height:'          . htmlspecialchars($height,       ENT_QUOTES, 'UTF-8'),
    '--moko-hero-overlay-opacity:' . $overlayOpacity,
    '--moko-hero-overlay-color:'   . htmlspecialchars($overlayColor, ENT_QUOTES, 'UTF-8'),
    '--moko-hero-text-color:'      . htmlspecialchars($textColor,    ENT_QUOTES, 'UTF-8'),
    '--moko-hero-align:'           . htmlspecialchars($contentAlign, ENT_QUOTES, 'UTF-8'),
    '--moko-hero-bg-position:'     . htmlspecialchars($bgPosition,   ENT_QUOTES, 'UTF-8'),
];

if ($isImage) {
    $cssVars[] = '--moko-hero-bg-image:url(' . htmlspecialchars($mediaUrl, ENT_QUOTES, 'UTF-8') . ')';
}

if ($isSlideshow && !empty($slides)) {
    $count         = count($slides);
    $cycleDuration = ($slideDuration + $slideTransition) * $count;
    $cssVars[]     = '--moko-slideshow-count:'      . $count;
    $cssVars[]     = '--moko-slideshow-duration:'   . $slideDuration . 's';
    $cssVars[]     = '--moko-slideshow-transition:' . $slideTransition . 's';
    $cssVars[]     = '--moko-slideshow-cycle:'      . $cycleDuration . 's';
}

$inlineStyle = implode(';', $cssVars);
?>
<div
    id="<?php echo $moduleId; ?>"
    class="<?php echo implode(' ', $modClasses); ?>"
    style="<?php echo $inlineStyle; ?>"
    role="banner"
    aria-label="<?php echo Text::_('MOD_MOKO_HERO_ARIA_LABEL'); ?>"
>

    <?php if ($isSlideshow && !empty($slides)) :
        $count     = count($slides);
        $cycleTime = ($slideDuration + $slideTransition) * $count;
        foreach ($slides as $i => $slide) :
            $delay        = ($slideDuration + $slideTransition) * $i;
            $slideIsVideo = $slide['type'] === 'video';
            $slideStyle   = 'animation-delay:' . $delay . 's;animation-duration:' . $cycleTime . 's;';
            if (!$slideIsVideo) {
                $slideStyle .= 'background-image:url(' . htmlspecialchars($slide['url'], ENT_QUOTES, 'UTF-8') . ');';
            }
    ?>
    <div
        class="mod-moko-hero__slide<?php echo $slideIsVideo ? ' mod-moko-hero__slide--video' : ''; ?>"
        style="<?php echo $slideStyle; ?>"
        aria-hidden="true"
    ><?php if ($slideIsVideo) : ?><video
            class="mod-moko-hero__video"
            autoplay muted loop playsinline
            aria-hidden="true" tabindex="-1"
        ><source src="<?php echo htmlspecialchars($slide['url'], ENT_QUOTES, 'UTF-8'); ?>" type="<?php echo $slide['mime']; ?>"></video><?php endif; ?></div>
    <?php endforeach; endif; ?>

    <?php if ($isVideo && !$isSlideshow) : ?>
    <video
        class="mod-moko-hero__video"
        autoplay muted loop playsinline
        aria-hidden="true" tabindex="-1"
    >
        <source
            src="<?php echo htmlspecialchars($mediaUrl, ENT_QUOTES, 'UTF-8'); ?>"
            type="<?php
                $ext     = strtolower(pathinfo($mediaUrl, PATHINFO_EXTENSION));
                $mimeMap = ['mp4' => 'video/mp4', 'webm' => 'video/webm', 'ogg' => 'video/ogg', 'ogv' => 'video/ogg'];
                echo $mimeMap[$ext] ?? 'video/mp4';
            ?>"
        >
    </video>
    <?php endif; ?>

    <?php if ($hasContent) : ?>
    <div class="banner-overlay">

        <?php if ($text1 !== '') : ?>
        <div class="mod-moko-hero__text1"><?php echo $text1; ?></div>
        <?php endif; ?>

        <?php if ($text2 !== '') : ?>
        <div class="mod-moko-hero__text2"><?php echo $text2; ?></div>
        <?php endif; ?>

        <?php if ($text3 !== '') : ?>
        <div class="mod-moko-hero__text3"><?php echo $text3; ?></div>
        <?php endif; ?>

        <?php if (!empty($buttons)) : ?>
        <div class="mod-moko-hero__buttons">
            <?php foreach ($buttons as $btn) : ?>
            <a
                href="<?php echo htmlspecialchars($btn['url'], ENT_QUOTES, 'UTF-8'); ?>"
                class="btn btn-lg <?php echo htmlspecialchars($btn['style'], ENT_QUOTES, 'UTF-8'); ?>"
            ><?php if ($btn['icon'] !== '') : ?><i class="<?php echo htmlspecialchars($btn['icon'], ENT_QUOTES, 'UTF-8'); ?>" aria-hidden="true"></i> <?php endif; ?><?php echo htmlspecialchars($btn['label'], ENT_QUOTES, 'UTF-8'); ?></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
    <?php endif; ?>

</div>
