# Contributing

Thanks for your interest in improving the Intellibook AI developer tools.

## Before you start

- For anything larger than a small fix, open an issue first so we can agree on the approach.
- Do not include secrets, customer data or real phone numbers in issues, commits or tests.

## Development

**CLI** (`packages/cli`, Node 18+, no dependencies):

```bash
node --check packages/cli/bin/intellibook.js
node packages/cli/bin/intellibook.js help
cd packages/cli && npm pack --dry-run
```

**WordPress plugin** (`plugins/wordpress/intellibook-ai-receptionist`, PHP 7.4+, WordPress 5.6+):

```bash
php -l plugins/wordpress/intellibook-ai-receptionist/intellibook-ai.php
```

Follow the [WordPress coding standards](https://developer.wordpress.org/coding-standards/): escape output, sanitise input, prefix all globals.

## Pull requests

- One logical change per pull request, with a clear description.
- CI must pass.
- Update `CHANGELOG.md` for user-visible changes.

## Licence

By contributing you agree your contribution is licensed under the licence of the part you change: MIT for the CLI and tooling, GPLv2 or later for the WordPress plugin.
