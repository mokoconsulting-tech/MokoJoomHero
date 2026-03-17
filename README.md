# mod_moko_hero — Joomla Hero Background Image Module

A Joomla 4/5 site module that displays a randomly selected image from a folder as the full-width CSS background of a hero overlay section — combining the image-scanning approach of `mod_random_image` with the visual overlay pattern of Cassiopeia's `mod_custom` banner layout override.

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

`mod_moko_hero` scans a configurable image folder (relative to the Joomla root), picks a random supported image on each page load, and renders it as the `background-image` of a full-width hero block. A semi-transparent colour overlay is applied via a CSS `::before` pseudo-element — identical to the technique used by Cassiopeia's built-in banner override — so the overlay is purely decorative and does not affect accessibility.

Administrators control the hero title, body text, call-to-action button, height, overlay colour and opacity, content alignment, and background position — all from the standard Joomla module parameters UI.

## Features

- **Random image selection** from any folder under the Joomla root (jpg, jpeg, png, gif, webp, avif)
- **CSS overlay** with configurable colour and opacity via inline CSS custom properties
- **Hero content** — title, rich-text body, and CTA button with configurable label and URL
- **Responsive** — `clamp()`-based fluid typography, `min-height` in `vh` units, mobile padding adjustments
- **Graceful fallback** — gradient background shown when no images are found; admin warning logged
- **Accessible** — `role="banner"`, `aria-label`, and overlay excluded from the tab order
- **Joomla 4 / 5 compatible** — PSR-4 namespaced Helper, `HTMLHelper::_('stylesheet', …)` asset loading
- **Zero external dependencies** — no JavaScript, no Composer packages required

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

4. **Upload images** to your chosen folder (default: `images/headers/`)

5. **Configure parameters** — set title, text, CTA, overlay colour/opacity

6. **Assign** the module to a full-width position (e.g. `banner` in Cassiopeia) and publish

### Common Make Tasks

```bash
make help        # List all available tasks
make validate    # PHP lint + CodeSniffer
make build       # Create dist/mod_moko_hero.zip
make dev-install # Symlink into JOOMLA_ROOT for live development
```

## Module Parameters

### Basic

| Parameter | Default | Description |
|-----------|---------|-------------|
| Image Folder | `images/headers` | Path relative to Joomla root containing hero images |
| Hero Title | *(empty)* | `<h2>` heading rendered over the image |
| Hero Text | *(empty)* | Supporting body text (safe HTML allowed) |
| Call-to-Action URL | *(empty)* | URL for the CTA button; leave blank to hide |
| Button Label | `Learn More` | Text on the CTA button |

### Display Settings

| Parameter | Default | Description |
|-----------|---------|-------------|
| Hero Height | `70vh` | CSS height (vh, px, %) |
| Overlay Opacity | `0.45` | 0 = transparent → 1 = solid |
| Overlay Colour | `#000000` | Colour of the overlay layer |
| Content Alignment | `center` | Left / Centre / Right |
| Text Colour | `#ffffff` | Colour for title, text, and button |
| Background Position | `center center` | Focal point of the background image |

### Supported Image Formats

`jpg`, `jpeg`, `png`, `gif`, `webp`, `avif`

## Project Structure

```
src/mod_moko_hero/
├── mod_moko_hero.php          # Module entry point — bootstraps helper + layout
├── mod_moko_hero.xml          # Extension manifest (params, namespace, files)
├── src/
│   └── Helper/
│       └── MokoHeroHelper.php # PSR-4 helper — folder scan + random image URL
├── tmpl/
│   └── default.php            # Hero layout — CSS vars + accessible markup
├── media/
│   └── css/
│       └── mod_moko_hero.css  # Overlay + typography styles (CSS custom properties)
└── language/
    └── en-GB/
        ├── mod_moko_hero.ini      # Frontend strings
        └── mod_moko_hero.sys.ini  # Admin (sys) strings
```

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
