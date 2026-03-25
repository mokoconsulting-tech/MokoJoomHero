# mod_moko_hero — Joomla Hero Media Module

A Joomla 4/5 site module that displays images and videos as full-width hero backgrounds with overlay content — supporting random selection, slideshow mode, rich text layers, and configurable call-to-action buttons.

[![License](https://img.shields.io/badge/license-GPL--3.0--or--later-blue.svg)](LICENSE)

## Table of Contents

1. [Overview](#overview)
2. [Features](#features)
3. [Prerequisites](#prerequisites)
4. [Installation](#installation)
5. [Usage](#usage)
6. [Module Parameters](#module-parameters)
7. [Project Structure](#project-structure)
8. [Development](#development)
9. [Testing](#testing)
10. [Building](#building)
11. [Contributing](#contributing)
12. [Versioning](#versioning)
13. [License](#license)
14. [Support](#support)

## Overview

`mod_moko_hero` scans a configurable image folder (relative to the Joomla root), picks media on each page load — either a single random item or a full slideshow rotation — and renders it as the background of a full-width hero block. A semi-transparent colour overlay is applied via a CSS `::before` pseudo-element, following the same technique used by Cassiopeia's built-in banner override.

Administrators control up to three WYSIWYG text layers, three call-to-action buttons with icon and style options, hero height, overlay colour/opacity, content alignment, and background position — all from the standard Joomla module parameters UI.

## Features

- **Random or slideshow display** — single random media item per page load, or CSS keyframe-driven slideshow with configurable duration and transition
- **Image and video support** — jpg, jpeg, png, gif, webp, avif for images; mp4, webm, ogg, ogv for video backgrounds
- **CSS overlay** with configurable colour and opacity via inline CSS custom properties
- **Three WYSIWYG text levels** — flexible rich-text content layers rendered over the hero
- **Three configurable buttons** — each with label, URL, FontAwesome icon, and Bootstrap style selection
- **Responsive** — `clamp()`-based fluid typography, `min-height` in `vh` units, mobile padding adjustments
- **Graceful fallback** — gradient background shown when no media files are found; admin warning logged
- **Accessible** — `role="banner"`, `aria-label`, video elements excluded from tab order
- **Joomla 4/5 native DI architecture** — `services/provider.php` with `ModuleDispatcherFactory` and PSR-4 namespaced Dispatcher/Helper
- **Zero external dependencies** — no Composer packages required; vanilla CSS animations for slideshow

## Prerequisites

- **PHP**: 8.1 or higher (Joomla 4.4 / 5.x requirement)
- **Joomla**: 4.4 or 5.x site installation for testing
- **PHP CodeSniffer** *(optional)*: `composer global require squizlabs/php_codesniffer` for code-quality checks
- **Make**: GNU Make for build commands
- **Git**: For version control

## Installation

### Via Joomla Extension Manager (recommended)

1. Run `make build` to produce `dist/mod_moko_hero.zip`
2. In Joomla Admin → **Extensions > Manage > Install**, upload the ZIP
3. Go to **Extensions > Modules**, create a new **Moko Hero** module
4. Set the **Image Folder** parameter (e.g. `images/headers`) and assign the module to a position

### Development Symlink

```bash
# Set JOOMLA_ROOT in the Makefile first
make dev-install
```

## Usage

### Quick Start

1. **Build the package**:
   ```bash
   make build
   ```

2. **Install** the generated `dist/mod_moko_hero.zip` in your Joomla site

3. **Create a module instance** in Joomla Admin → Extensions > Modules → New → Moko Hero

4. **Upload media** to your chosen folder (default: `images/headers/`)

5. **Configure parameters** — set text layers, buttons, display mode, overlay colour/opacity

6. **Assign** the module to a full-width position (e.g. `banner` in Cassiopeia) and publish

### Common Make Tasks

```bash
make help        # List all available tasks
make validate    # PHP lint + CodeSniffer
make build       # Create dist/mod_moko_hero.zip
make dev-install # Symlink into JOOMLA_ROOT for live development
```

## Module Parameters

### Basic (Content)

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| Image Folder | folderlist | `images/headers` | Subfolder under `images/` containing hero media files |
| Text Level 1 | WYSIWYG editor | *(empty)* | Primary rich-text content layer |
| Text Level 2 | WYSIWYG editor | *(empty)* | Secondary rich-text content layer |
| Text Level 3 | WYSIWYG editor | *(empty)* | Tertiary rich-text content layer |
| Button 1 Label | text | *(empty)* | Text for button 1; leave blank to hide |
| Button 1 Icon | text | *(empty)* | FontAwesome class (e.g. `fas fa-arrow-right`) |
| Button 1 URL | url | *(empty)* | Link destination for button 1 |
| Button 1 Style | list | `btn-primary` | Bootstrap button style class |
| Button 2 Label | text | *(empty)* | Text for button 2; leave blank to hide |
| Button 2 Icon | text | *(empty)* | FontAwesome class for button 2 |
| Button 2 URL | url | *(empty)* | Link destination for button 2 |
| Button 2 Style | list | `btn-outline-light` | Bootstrap button style class |
| Button 3 Label | text | *(empty)* | Text for button 3; leave blank to hide |
| Button 3 Icon | text | *(empty)* | FontAwesome class for button 3 |
| Button 3 URL | url | *(empty)* | Link destination for button 3 |
| Button 3 Style | list | `btn-secondary` | Bootstrap button style class |

### Display Settings

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| Display Mode | list | `random` | `random` (single item) or `slideshow` (rotate all) |
| Slide Duration | number | `5` | Seconds each slide is visible (slideshow only, 2–30) |
| Slide Transition | number | `1` | Crossfade transition duration in seconds (slideshow only, 0.5–5) |
| Hero Height | text | `70vh` | CSS height value (vh, px, %) |
| Overlay Opacity | range | `0.45` | 0 = transparent → 1 = solid |
| Overlay Colour | color | `#000000` | Colour of the overlay layer |
| Content Alignment | list | `center` | Left / Centre / Right |
| Text Colour | color | `#ffffff` | Colour for all text and button content |
| Background Position | list | `center center` | Focal point of the background media |

### Button Style Options

All three buttons support these Bootstrap style classes:
- `btn-primary` — Primary
- `btn-secondary` — Secondary
- `btn-outline-primary` — Outline Primary
- `btn-outline-light` — Outline Light
- `btn-light` — Light
- `btn-dark` — Dark

### Supported Media Formats

**Images:** `jpg`, `jpeg`, `png`, `gif`, `webp`, `avif`
**Videos:** `mp4`, `webm`, `ogg`, `ogv`

## Project Structure

```
src/
├── mod_moko_hero.xml              # Extension manifest (params, namespace, files)
├── services/
│   └── provider.php               # Joomla DI service provider (registers dispatcher)
├── src/
│   └── Site/
│       ├── Dispatcher/
│       │   └── Dispatcher.php     # Module dispatcher — resolves display mode + layout data
│       └── Helper/
│           └── MokoHeroHelper.php # Folder scanner — image/video discovery + URL resolution
├── tmpl/
│   └── default.php                # Hero layout — CSS vars, slideshow, video, accessible markup
├── media/
│   └── css/
│       └── mod_moko_hero.css      # Overlay + typography + slideshow animation styles
└── language/
    └── en-GB/
        ├── mod_moko_hero.ini      # Frontend strings
        └── mod_moko_hero.sys.ini  # Admin (sys) strings
```

### Architecture

The module uses Joomla's native Dependency Injection module pattern:

1. **`services/provider.php`** — Registers `ModuleDispatcherFactory` and `Module` with the DI container. The factory auto-resolves the `Dispatcher` class from the module's namespace.

2. **`Dispatcher`** — Extends `AbstractModuleDispatcher`. Overrides `getLayoutData()` to call the Helper and populate the template variables (`mediaUrl`, `mediaType`, `slides`, `displayMode`).

3. **`MokoHeroHelper`** — Scans the configured folder for supported image/video files using `DirectoryIterator`. Returns either all media items (slideshow) or a single random pick.

4. **`default.php`** — Renders the hero markup using CSS custom properties for theming. Handles three render paths: single image (CSS `background-image`), single video (`<video>` element), or slideshow (multiple slide divs with CSS keyframe animations).

## Development

### Setting Up Development Environment

1. **Install dependencies**:
	 ```bash
	 # Install PHP CodeSniffer globally
	 composer global require squizlabs/php_codesniffer
	 composer global require dealerdirect/phpcodesniffer-composer-installer
	 ```

2. **Configure your IDE** to use the `.editorconfig` settings

3. **Set up pre-commit hooks** (optional):
	 ```bash
	 git config commit.template .gitmessage
	 ```

### Development Workflow

See [docs/DEVELOPMENT.md](docs/DEVELOPMENT.md) for detailed development guidelines.

### Code Style

This project follows:
- Joomla Coding Standards for PHP
- Tab indentation (width: 2 spaces)
- LF line endings
- UTF-8 encoding

## Testing

### Manual Testing

1. **Create development symlink**:
	 ```bash
	 # Update JOOMLA_ROOT in Makefile first
	 make dev-install
	 ```

2. **Test in Joomla**:
	 - Enable the module in Joomla admin
	 - Assign to a module position
	 - Test on frontend/backend

### Automated Testing

```bash
make lint      # PHP syntax check
make phpcs     # Code standards check
make validate  # Run all checks
```

## Building

### Build Module Package

```bash
make build
```

This creates a ZIP package in the `dist/` directory ready for installation in Joomla.

### Installing to Joomla

**Option 1: Upload via Joomla Admin**
```bash
make install-local
```
Then upload the generated ZIP file via Extensions > Manage > Install

**Option 2: Development Symlink**
```bash
make dev-install
```
Creates a symlink for development (requires configured JOOMLA_ROOT)

## Contributing

We welcome contributions! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

### Quick Contribution Guide

1. Fork the repository
2. Create a feature branch (`git checkout -b feat/amazing-feature`)
3. Commit your changes using conventional commits
4. Push to your branch
5. Open a Pull Request

## Versioning

This project uses [Semantic Versioning](https://semver.org/):
- **MAJOR**: Incompatible API changes
- **MINOR**: New functionality (backward compatible)
- **PATCH**: Bug fixes (backward compatible)

See [CHANGELOG.md](CHANGELOG.md) for version history.

## License

Copyright (C) 2026 Moko Consulting <hello@mokoconsulting.tech>

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.

SPDX-License-Identifier: GPL-3.0-or-later

### License Management

This repository includes a GitHub Actions workflow for syncing all GPL licenses (GPL-2.0, GPL-3.0, LGPL-2.1, LGPL-3.0) from www.gnu.org. The workflow must be triggered manually - automatic scheduling is disabled. The primary GPL-3.0 license is maintained in the LICENSE file, with additional licenses stored in the `licenses/` directory. For enterprise environments with firewall restrictions, see [Firewall Configuration Guide](docs/FIREWALL_CONFIGURATION.md) for required network access configuration.

## Support

- **Documentation**: See the [docs/](docs/) directory
- **Issues**: Report bugs and request features via [GitHub Issues](../../issues)
- **Contact**: hello@mokoconsulting.tech
- **Website**: [mokoconsulting.tech](https://mokoconsulting.tech)

## Acknowledgments

This template is maintained by Moko Consulting and follows MokoStandards for consistent, high-quality Joomla module development.
