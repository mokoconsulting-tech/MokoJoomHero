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
 *       <h1 class="display-4 text-thin">…</h1>
 *       <div class="lead">…</div>
 *       <p><a class="btn btn-primary btn-lg">…</a></p>
 *     </div>
 *   </div>
 *
 * Using .container-banner and .banner-overlay means Cassiopeia's built-in CSS
 * rules for those selectors apply here automatically, keeping both modules
 * visually consistent on the same site.
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
$heroTitle       = $params->get('hero_title', '');
$heroText        = $params->get('hero_text', '');
$link            = trim((string) $params->get('link', ''));
$linkText        = $params->get('link_text', Text::_('MOD_MOKO_HERO_LEARN_MORE'));
$height          = $params->get('height', '70vh');
$overlayOpacity  = (float) $params->get('overlay_opacity', 0.45);
$overlayColor    = $params->get('overlay_color', '#000000');
$contentAlign    = $params->get('content_align', 'center');
$textColor       = $params->get('text_color', '#ffffff');
$bgPosition      = $params->get('bg_position', 'center center');
$slideDuration   = (int) $params->get('slide_duration', 5);
$slideTransition = (float) $params->get('slide_transition', 1.0);

$isSlideshow = $displayMode === 'slideshow';
$isImage     = $mediaType === 'image';
$isVideo     = $mediaType === 'video';
$hasMedia    = $mediaUrl !== '' || !empty($slides);

// ── Root element classes ──────────────────────────────────────────────────────
// .container-banner  — Cassiopeia-native outer wrapper (same as mod_custom banner)
// .mod-moko-hero     — our scoping prefix for module-specific rules
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
$hasContent  = $heroTitle !== '' || $heroText !== '' || $link !== '';
?>
<div
    id="<?php echo $moduleId; ?>"
    class="<?php echo implode(' ', $modClasses); ?>"
    style="<?php echo $inlineStyle; ?>"
    role="banner"
    aria-label="<?php echo $heroTitle !== '' ? htmlspecialchars($heroTitle, ENT_QUOTES, 'UTF-8') : Text::_('MOD_MOKO_HERO_ARIA_LABEL'); ?>"
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
    <!--
        .banner-overlay is the Cassiopeia-native class from the built-in
        mod_custom banner template override. Reusing it here means Cassiopeia's
        stylesheet rules for the overlay panel apply automatically.
    -->
    <div class="banner-overlay">

        <?php if ($heroTitle !== '') : ?>
        <h1 class="display-4 text-thin">
            <?php echo htmlspecialchars($heroTitle, ENT_QUOTES, 'UTF-8'); ?>
        </h1>
        <?php endif; ?>

        <?php if ($heroText !== '') : ?>
        <div class="lead">
            <?php echo $heroText; ?>
        </div>
        <?php endif; ?>

        <?php if ($link !== '') : ?>
        <p>
            <a
                href="<?php echo htmlspecialchars($link, ENT_QUOTES, 'UTF-8'); ?>"
                class="btn btn-primary btn-lg"
            ><?php echo htmlspecialchars($linkText, ENT_QUOTES, 'UTF-8'); ?></a>
        </p>
        <?php endif; ?>

    </div>
    <?php endif; ?>

</div>
