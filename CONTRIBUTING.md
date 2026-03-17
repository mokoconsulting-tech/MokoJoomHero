# Contributing to MokoStandards-Template-Joomla-Module

Thank you for your interest in contributing to this project! This document provides guidelines and instructions for contributing.

## Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Process](#development-process)
- [Coding Standards](#coding-standards)
- [Commit Guidelines](#commit-guidelines)
- [Pull Request Process](#pull-request-process)
- [Reporting Issues](#reporting-issues)
- [Questions and Support](#questions-and-support)

## Code of Conduct

This project and everyone participating in it is governed by our [Code of Conduct](CODE_OF_CONDUCT.md). By participating, you are expected to uphold this code. Please report unacceptable behavior to hello@mokoconsulting.tech.

## Getting Started

### Prerequisites

Before contributing, ensure you have:

- PHP 7.4 or higher installed
- Composer installed (for dependency management)
- PHP CodeSniffer installed (`composer global require squizlabs/php_codesniffer`)
- A working Joomla installation for testing
- Git installed and configured

### Setting Up Your Development Environment

1. **Fork the repository** on GitHub

2. **Clone your fork**:
	 ```bash
	 git clone https://github.com/your-username/MokoStandards-Template-Joomla-Module.git
	 cd MokoStandards-Template-Joomla-Module
	 ```

3. **Add the upstream remote**:
	 ```bash
	 git remote add upstream https://github.com/mokoconsulting-tech/MokoStandards-Template-Joomla-Module.git
	 ```

4. **Configure git commit template**:
	 ```bash
	 git config commit.template .gitmessage
	 ```

5. **Install development dependencies**:
	 ```bash
	 composer install
	 ```

## Development Process

### Branching Strategy

- `main` - Stable, production-ready code
- `feat/*` - New features
- `fix/*` - Bug fixes
- `docs/*` - Documentation updates
- `refactor/*` - Code refactoring
- `chore/*` - Maintenance tasks

### Workflow

1. **Create a branch** from `main`:
	 ```bash
	 git checkout main
	 git pull upstream main
	 git checkout -b feat/your-feature-name
	 ```

2. **Make your changes** following our coding standards

3. **Test your changes**:
	 ```bash
	 make validate    # Run linters and code standards checks
	 make build       # Build the module package
	 ```

4. **Commit your changes** using conventional commits (see below)

5. **Push to your fork**:
	 ```bash
	 git push origin feat/your-feature-name
	 ```

6. **Open a Pull Request** from your branch to `main`

## Coding Standards

### PHP Standards

- Follow [Joomla Coding Standards](https://developer.joomla.org/coding-standards.html)
- Use tabs for indentation (width: 2 spaces)
- Use UTF-8 encoding without BOM
- Use LF (Unix) line endings
- Include proper DocBlocks for classes, methods, and properties
- Use type hints where applicable

### File Headers

All PHP files should include the following header:

```php
<?php
/**
 * @package     ModuleName
 * @subpackage  mod_modulename
 * @copyright   Copyright (C) 2026 Moko Consulting. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;
```

### Code Quality

Before submitting:

- Run PHP syntax check: `make lint`
- Run PHP CodeSniffer: `make phpcs`
- Run all checks: `make validate`
- Fix auto-fixable issues: `make phpcbf`

## Commit Guidelines

We follow [Conventional Commits](https://www.conventionalcommits.org/) specification.

### Commit Message Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- **feat**: A new feature
- **fix**: A bug fix
- **docs**: Documentation only changes
- **style**: Code style changes (formatting, missing semicolons, etc.)
- **refactor**: Code change that neither fixes a bug nor adds a feature
- **perf**: Performance improvements
- **test**: Adding or updating tests
- **build**: Changes to build system or dependencies
- **ci**: Changes to CI configuration
- **chore**: Other changes that don't modify src or test files
- **revert**: Reverts a previous commit

### Examples

```bash
# Feature
feat(module): add contact form validation

# Bug fix
fix(display): correct responsive layout on mobile devices

# Documentation
docs(readme): update installation instructions

# Breaking change
feat(api)!: change module configuration structure

BREAKING CHANGE: Configuration now uses nested arrays instead of flat structure
```

### Rules

- Use imperative, present tense: "change" not "changed" nor "changes"
- Don't capitalize first letter
- No period (.) at the end
- Keep subject line under 50 characters
- Wrap body at 72 characters
- Separate subject from body with a blank line
- Use body to explain what and why vs. how

## Pull Request Process

### Before Submitting

1. **Update documentation** if you've changed functionality
2. **Update CHANGELOG.md** with a description of changes
3. **Ensure all tests pass**: `make validate`
4. **Ensure no merge conflicts** with `main`
5. **Keep commits atomic** - one logical change per commit
6. **Squash commits** if you have multiple small commits for one change

### Pull Request Guidelines

- **Title**: Use conventional commit format
- **Description**: Explain what and why (not how)
- **Link issues**: Use "Closes #123" or "Fixes #123"
- **Screenshots**: Include for UI changes
- **Breaking changes**: Clearly document any breaking changes
- **Documentation**: Include relevant documentation updates

### Review Process

1. At least one maintainer must review and approve
2. All CI checks must pass
3. No unresolved review comments
4. Branch must be up to date with `main`

### After Merge

- Delete your feature branch
- Pull the latest `main` branch
- Update your fork

## Reporting Issues

### Bug Reports

When reporting bugs, include:

- **Clear title**: Brief description of the issue
- **Environment**: PHP version, Joomla version, OS
- **Steps to reproduce**: Numbered list of steps
- **Expected behavior**: What should happen
- **Actual behavior**: What actually happens
- **Screenshots**: If applicable
- **Error messages**: Full error text or stack traces

### Feature Requests

When requesting features, include:

- **Clear title**: Brief description of the feature
- **Problem statement**: What problem does this solve?
- **Proposed solution**: How should it work?
- **Alternatives considered**: Other approaches you've thought about
- **Additional context**: Any other relevant information

### Issue Labels

- `bug` - Something isn't working
- `enhancement` - New feature or request
- `documentation` - Improvements or additions to documentation
- `good first issue` - Good for newcomers
- `help wanted` - Extra attention is needed
- `question` - Further information is requested

## Questions and Support

- **Documentation**: Check the [docs/](docs/) directory first
- **Issues**: Search existing issues before creating new ones
- **Email**: hello@mokoconsulting.tech
- **Discussions**: Use GitHub Discussions for general questions

## Development Resources

- [Joomla Developer Documentation](https://docs.joomla.org/Developer_Documentation)
- [Joomla Coding Standards](https://developer.joomla.org/coding-standards.html)
- [PHP The Right Way](https://phptherightway.com/)
- [Conventional Commits](https://www.conventionalcommits.org/)
- [Semantic Versioning](https://semver.org/)

## License

By contributing, you agree that your contributions will be licensed under the GNU General Public License v3.0 or later.

---

Thank you for contributing to MokoStandards-Template-Joomla-Module!
