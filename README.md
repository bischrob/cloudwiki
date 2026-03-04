# cloudwiki

CloudWiki is a Nextcloud app for fast raw Markdown note editing with Obsidian-style `[[wikilinks]]`, backlinks, and native Nextcloud permissions/sharing/version behavior.

## Core Requirement
CloudWiki must support interoperable editing with Obsidian when both point to the same Nextcloud-synced folder: a user can edit a note in Obsidian and then edit that same note in CloudWiki (and vice versa) without conversion or lock-in.

## Planning Docs
- [Scope](./scope.md)
- [TODO](./TODO.md)
- [Vault Index](./Vault/Index.md)

## MVP Focus
- Raw markdown editor (no live preview)
- Wikilink suggestions, navigation, and note creation
- Backlinks panel
- Nextcloud-native auth, ACL, and file handling

## Project Setup Status
Step 2 (Project Setup) is scaffolded:
- Nextcloud app baseline directories and bootstrap files
- Frontend toolchain (Vue + TypeScript + Vite + Vitest)
- PHP quality tooling (PHP-CS-Fixer + PHPStan + PHPUnit)
- GitHub Actions CI for lint, test, and build
- Contributor and local development docs

## Runtime Status
- Step 3 completed: app metadata, bootstrap, navigation entry, and route registration.
- Step 4 partially completed: file open/save APIs implemented with ETag conflict detection.

### Implemented API Endpoints
- `GET /apps/cloudwiki/api/file?path=<relative.md>`
- `PUT /apps/cloudwiki/api/file`
  - JSON body: `path`, `content`, `expectedEtag` (optional but recommended)

## Quick Start
1. `nvm use`
2. `composer install`
3. `npm ci`
4. `make lint`
5. `make test`
6. `make build`
