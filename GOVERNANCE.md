# Project Governance

This document describes the governance structure and processes for the MokoStandards-Template-Joomla-Module project.

## Overview

This project follows a benevolent dictator model with community input. Moko Consulting maintains primary stewardship while welcoming community contributions and feedback.

## Roles and Responsibilities

### Maintainers

**Primary Maintainers**: Moko Consulting Team

Responsibilities:
- Review and merge pull requests
- Triage and respond to issues
- Release management and versioning
- Set project direction and roadmap
- Enforce code of conduct
- Update and maintain documentation
- Ensure project quality standards

### Contributors

Anyone who contributes code, documentation, or other improvements to the project.

Rights:
- Submit pull requests
- Report issues and suggest features
- Participate in discussions
- Review pull requests (non-binding)

Responsibilities:
- Follow the code of conduct
- Adhere to contribution guidelines
- Write quality code and documentation
- Respect maintainer decisions

### Users

Anyone who uses this template for their Joomla module projects.

Rights:
- Use the template freely under the GPL-3.0 license
- Report bugs and request features
- Participate in community discussions
- Receive support through documented channels

## Decision Making Process

### Minor Decisions

Minor decisions include:
- Bug fixes
- Documentation improvements
- Code refactoring without API changes
- Dependency updates (non-breaking)

**Process**: 
- Contributor submits pull request
- Maintainer reviews and approves/requests changes
- One maintainer approval required for merge

### Major Decisions

Major decisions include:
- New features
- Breaking changes
- Architecture changes
- License changes
- Governance changes

**Process**:
1. Proposal submitted as GitHub issue or discussion
2. Community discussion period (minimum 7 days)
3. Maintainers evaluate feedback
4. Final decision by project leads
5. Decision documented in issue/discussion

## Communication Channels

### Primary Channels

- **GitHub Issues**: Bug reports, feature requests, technical discussions
- **GitHub Pull Requests**: Code review and discussion
- **GitHub Discussions**: General questions and community discussion
- **Email**: hello@mokoconsulting.tech for private matters

### Response Times

We aim for:
- **Critical bugs**: Response within 24-48 hours
- **Pull requests**: Initial review within 3-5 business days
- **Issues**: Triage and response within 5-7 business days
- **General inquiries**: Response within 7-10 business days

Note: These are goals, not guarantees. Response times may vary based on maintainer availability.

## Contribution Process

1. **Discuss**: For major changes, open an issue first
2. **Fork**: Create a fork of the repository
3. **Branch**: Create a feature branch
4. **Code**: Make your changes following standards
5. **Test**: Ensure all checks pass
6. **Submit**: Open a pull request
7. **Review**: Respond to feedback
8. **Merge**: Maintainer merges when approved

See [CONTRIBUTING.md](CONTRIBUTING.md) for detailed guidelines.

## Release Process

### Versioning

We follow [Semantic Versioning](https://semver.org/) (SemVer):

- **MAJOR** (X.0.0): Incompatible API changes
- **MINOR** (0.X.0): New features, backward compatible
- **PATCH** (0.0.X): Bug fixes, backward compatible

### Release Cycle

- **Patch releases**: As needed for bug fixes
- **Minor releases**: Quarterly or when significant features accumulate
- **Major releases**: Annually or when breaking changes are necessary

### Release Authority

- Maintainers are responsible for creating releases
- Releases must be tagged in Git with version number
- Each release must have a corresponding CHANGELOG entry
- Release notes should summarize changes for users

## Code Review

### Review Requirements

- All code must be reviewed before merging
- At least one maintainer approval required
- All CI checks must pass
- No unresolved conversations
- Branch must be up-to-date with target branch

### Review Criteria

Reviewers evaluate:
- **Functionality**: Does it work as intended?
- **Code quality**: Is it well-written and maintainable?
- **Standards compliance**: Does it follow our coding standards?
- **Documentation**: Is it properly documented?
- **Tests**: Are there appropriate tests?
- **Security**: Are there security implications?
- **Performance**: Are there performance impacts?

## Conflict Resolution

### Process

1. **Discussion**: Attempt to resolve through respectful discussion
2. **Mediation**: If unresolved, request maintainer mediation
3. **Decision**: Maintainers make final decision
4. **Appeal**: Can be appealed to project leads
5. **Final**: Project lead decision is final

### Code of Conduct Violations

Violations of the [Code of Conduct](CODE_OF_CONDUCT.md) are handled separately:
1. Report to hello@mokoconsulting.tech
2. Maintainers investigate privately
3. Action taken per enforcement guidelines
4. Reporter notified of outcome

## Project Roadmap

### Planning

- Roadmap discussed in GitHub Discussions
- Community input welcomed
- Maintainers set final priorities
- Roadmap updated quarterly

### Tracking

- Roadmap items tracked as GitHub issues
- Milestones used for release planning
- Projects board for work in progress

## Governance Changes

### Proposing Changes

To propose changes to this governance document:

1. Open a GitHub issue with the `governance` label
2. Clearly describe proposed changes and rationale
3. Allow minimum 14-day discussion period
4. Maintainers evaluate feedback
5. Final decision by project leads

### Approval

- Governance changes require consensus among maintainers
- Changes must be documented in Git history
- Announce changes to community

## Licensing

### Code License

All code contributions are licensed under GNU General Public License v3.0 or later (GPL-3.0-or-later).

### Documentation License

Documentation is licensed under the same GPL-3.0-or-later license.

### Copyright Assignment

Contributors retain copyright of their contributions but grant license per GPL-3.0-or-later.

## Maintainer Changes

### Adding Maintainers

New maintainers may be added when:
- Consistent, quality contributions over time
- Demonstrated understanding of project goals
- Available time to fulfill responsibilities
- Nominated by existing maintainer
- Approved by project leads

### Removing Maintainers

Maintainers may step down voluntarily or be removed for:
- Prolonged inactivity
- Code of conduct violations
- Failure to fulfill responsibilities
- Consensus among remaining maintainers

## Acknowledgments

This governance model is inspired by:
- [Contributor Covenant](https://www.contributor-covenant.org/)
- [Open Source Guides](https://opensource.guide/)
- Established open source project governance practices

## Contact

For governance questions or concerns:
- **Email**: hello@mokoconsulting.tech
- **GitHub**: Open an issue with the `governance` label

---

**Last Updated**: 2026-01-16  
**Version**: 1.0.0
