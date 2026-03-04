# Developer Setup

## Toolchain
- Node.js 20 (`.nvmrc`)
- npm 10+
- PHP 8.2+
- Composer 2+

## Bootstrap
1. `nvm use` (or install Node 20 manually)
2. `composer install`
3. `npm ci`

## Run Checks
- `npm run lint`
- `npm run format`
- `npm run typecheck`
- `npm run test`
- `composer lint:php`
- `composer stan`
- `composer test:php`

## Build
- `npm run build`

Build output is written to `js/cloudwiki-main.js`.
