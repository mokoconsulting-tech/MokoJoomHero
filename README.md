# MokoStandards-Template-Joomla-Module

A repository template for Joomla Module development projects following MokoStandards.

[![License](https://img.shields.io/badge/license-GPL--3.0--or--later-blue.svg)](LICENSE)

## Table of Contents

1. [Overview](#overview)
2. [Features](#features)
3. [Prerequisites](#prerequisites)
4. [Installation](#installation)
5. [Usage](#usage)
6. [Project Structure](#project-structure)
7. [Development](#development)
8. [Testing](#testing)
9. [Building](#building)
10. [Contributing](#contributing)
11. [Versioning](#versioning)
12. [License](#license)
13. [Support](#support)

## Overview

This is a standardized template repository for creating Joomla modules that conform to Moko Consulting's development standards and best practices. It provides a consistent starting point with pre-configured tooling, documentation structure, and development workflows.

Use this template when creating new Joomla modules to ensure:
- Consistent code structure and organization
- Pre-configured development tools (linters, formatters)
- Standardized documentation and contribution guidelines
- Built-in build and deployment workflows

## Features

- **Standardized Structure**: Pre-organized directories for source code, documentation, and scripts
- **Build Automation**: Makefile with common tasks (lint, build, package, install)
- **Code Quality**: Pre-configured PHP linting and CodeSniffer for Joomla standards
- **Development Tools**: EditorConfig for consistent coding styles across IDEs
- **Documentation**: Template structure following MokoStandards documentation practices
- **Git Configuration**: Pre-configured git attributes, ignore patterns, and commit message templates

## Prerequisites

Before using this template, ensure you have the following installed:

- **PHP**: 7.4 or higher (8.0+ recommended for Joomla 4.x/5.x)
- **Composer**: For PHP dependency management (optional but recommended)
- **Joomla**: A working Joomla installation for testing (3.x, 4.x, or 5.x)
- **PHP CodeSniffer**: For code quality checks (`composer global require squizlabs/php_codesniffer`)
- **Make**: GNU Make for running build commands
- **Git**: For version control

## Installation

### Using This Template

1. **Create a new repository from this template**:
	 - Click "Use this template" button on GitHub
	 - Or clone and remove git history:
		 ```bash
		 git clone https://github.com/mokoconsulting-tech/MokoStandards-Template-Joomla-Module.git my-joomla-module
		 cd my-joomla-module
		 rm -rf .git
		 git init
		 ```

2. **Customize for your module**:
	 - Update `Makefile` with your module name, type, and version
	 - Update this README with your module's specific information
	 - Update LICENSE file with appropriate copyright holder
	 - Create your module files in the `src/` directory

3. **Initialize git**:
	 ```bash
	 git add .
	 git commit -m "feat: initial commit from template"
	 ```

## Usage

### Quick Start

1. **Configure your module** in the `Makefile`:
	 ```makefile
	 MODULE_NAME := yourmodulename
	 MODULE_TYPE := site    # or 'admin' for backend modules
	 MODULE_VERSION := 1.0.0
	 ```

2. **Run the help command** to see available tasks:
	 ```bash
	 make help
	 ```

3. **Develop your module** in the `src/` directory

4. **Validate your code**:
	 ```bash
	 make validate
	 ```

5. **Build the module package**:
	 ```bash
	 make build
	 ```

### Common Tasks

See the [Development Guide](docs/DEVELOPMENT.md) for detailed development workflows.

## Project Structure

```
.
├── docs/               # Documentation files
├── scripts/            # Build and deployment scripts
├── src/                # Module source code
├── .editorconfig       # Editor configuration
├── .gitignore          # Git ignore patterns
├── .gitmessage         # Git commit message template
├── Makefile            # Build automation
└── README.md           # This file
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
