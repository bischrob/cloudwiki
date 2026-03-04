# Contributing

## Prerequisites
- PHP 8.2+
- Composer 2+
- Node.js 20 (see `.nvmrc`)

## Setup
1. Install PHP dependencies:
   `composer install`
2. Install frontend dependencies:
   `npm ci`

## Development Commands
- `npm run dev` - start frontend dev server
- `npm run build` - build frontend assets
- `npm run lint` - run ESLint
- `npm run format` - run Prettier check
- `npm run test` - run frontend tests
- `composer lint:php` - run PHP coding standard checks
- `composer stan` - run PHPStan
- `composer test:php` - run PHPUnit

## Pull Requests
- Keep changes scoped and documented.
- Ensure lint and tests pass before opening a PR.
