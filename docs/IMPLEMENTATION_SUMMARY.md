# Implementation Summary: mod_moko_hero

## Overview

`mod_moko_hero` is a Joomla 4/5 site module that renders a full-width hero section with a media background (images or video), configurable overlay, rich-text content layers, and call-to-action buttons. It supports both single random media selection and CSS-animated slideshow mode.

## Architecture

The module uses Joomla's native Dependency Injection (DI) module pattern — no legacy `mod_moko_hero.php` entry point.

### Request Flow

```
Joomla Module Renderer
  └─ services/provider.php          registers ModuleDispatcherFactory + Module
       └─ Dispatcher::getLayoutData()   resolves display mode, calls Helper
            └─ MokoHeroHelper           scans folder, returns media items
                 └─ tmpl/default.php    renders hero markup with CSS custom properties
```

### Key Files

| File | Purpose |
|------|---------|
| `services/provider.php` | DI service provider — registers `ModuleDispatcherFactory` (auto-resolves Dispatcher from namespace) and `Module` |
| `src/Site/Dispatcher/Dispatcher.php` | Extends `AbstractModuleDispatcher` — overrides `getLayoutData()` to populate template variables based on display mode |
| `src/Site/Helper/MokoHeroHelper.php` | Scans configured folder via `DirectoryIterator` for supported media; returns all items or a single random pick |
| `tmpl/default.php` | Layout template — three render paths (image, video, slideshow) using CSS custom properties |
| `media/css/mod_moko_hero.css` | Styles for overlay, typography, slideshow keyframes, responsive adjustments |
| `mod_moko_hero.xml` | Extension manifest — namespace, file declarations, module parameters |

### Namespace

```
MokoConsulting\Module\MokoHero\Site\Dispatcher\Dispatcher
MokoConsulting\Module\MokoHero\Site\Helper\MokoHeroHelper
```

The `<namespace path="src">` directive in the manifest maps the PSR-4 root to the module's `src/` subdirectory.

## Display Modes

### Random Mode (default)

The Dispatcher calls `MokoHeroHelper::getRandomMedia($params)` which:
1. Scans the configured folder for supported files
2. Returns a single random item as `['url' => ..., 'type' => 'image'|'video', 'mime' => ...]`

The template renders either a CSS `background-image` (images) or an autoplay `<video>` element (videos).

### Slideshow Mode

The Dispatcher calls `MokoHeroHelper::getAllMedia($params)` which returns all media items. The template renders multiple `.mod-moko-hero__slide` divs, each with CSS `animation-delay` and `animation-duration` properties driving a fade-in/fade-out keyframe cycle.

Configuration:
- **Slide Duration**: 2–30 seconds per slide
- **Slide Transition**: 0.5–5 seconds crossfade

## Content Structure

The hero overlay follows the Cassiopeia `mod_custom` "banner" override pattern:

```html
<div class="container-banner mod-moko-hero" role="banner">
    <!-- slides / video rendered here if applicable -->
    <div class="overlay">
        <div class="mod-moko-hero__text1">…</div>   <!-- WYSIWYG level 1 -->
        <div class="mod-moko-hero__text2">…</div>   <!-- WYSIWYG level 2 -->
        <div class="mod-moko-hero__text3">…</div>   <!-- WYSIWYG level 3 -->
        <div class="mod-moko-hero__buttons">
            <a class="btn btn-lg btn-primary">…</a>  <!-- up to 3 buttons -->
        </div>
    </div>
</div>
```

### Buttons

Up to three buttons, each with:
- **Label** — button text (required to show)
- **Icon** — FontAwesome class (e.g. `fas fa-arrow-right`)
- **URL** — link destination
- **Style** — Bootstrap button class (`btn-primary`, `btn-secondary`, `btn-outline-primary`, `btn-outline-light`, `btn-light`, `btn-dark`)

Conditional rendering via `showon` — icon, URL, and style fields only appear when a label is set.

## Supported Media

| Type | Extensions | Render Method |
|------|-----------|---------------|
| Image | jpg, jpeg, png, gif, webp, avif | CSS `background-image` |
| Video | mp4, webm, ogg, ogv | HTML `<video autoplay muted loop playsinline>` |

## CSS Custom Properties

All visual parameters are passed as CSS custom properties on the root element, allowing theme overrides without modifying PHP:

| Property | Default | Controls |
|----------|---------|----------|
| `--moko-hero-height` | `70vh` | Hero section height |
| `--moko-hero-overlay-opacity` | `0.45` | Overlay transparency |
| `--moko-hero-overlay-color` | `#000000` | Overlay colour |
| `--moko-hero-text-color` | `#ffffff` | Text and button colour |
| `--moko-hero-align` | `center` | Content alignment (flex) |
| `--moko-hero-bg-position` | `center center` | Background image focal point |
| `--moko-hero-bg-image` | *(none)* | Background image URL (random image mode) |
| `--moko-slideshow-count` | *(none)* | Number of slides |
| `--moko-slideshow-duration` | *(none)* | Per-slide display time |
| `--moko-slideshow-transition` | *(none)* | Crossfade duration |
| `--moko-slideshow-cycle` | *(none)* | Total cycle duration |

## Accessibility

- `role="banner"` and `aria-label` on root element
- Video elements have `aria-hidden="true"` and `tabindex="-1"`
- Slideshow slides are `aria-hidden="true"` (decorative)
- Overlay is purely CSS (`::before` pseudo-element) — no DOM impact on assistive tech

## Fallback Behaviour

When no media files are found in the configured folder:
- Admin warning message is enqueued via `Factory::getApplication()->enqueueMessage()`
- Module renders with `mod-moko-hero--no-media` class
- CSS provides a gradient fallback background

## License Sync Workflow

The repository includes a GitHub Actions workflow (`download-license.yml`) for syncing GPL licenses from www.gnu.org. See [FIREWALL_CONFIGURATION.md](FIREWALL_CONFIGURATION.md) for enterprise firewall requirements and [QUICKSTART.md](QUICKSTART.md) for setup instructions.
