# Resumption Checklist

When resuming work in this repository:

1. Read `../README.md`, `../scope.md`, and `../TODO.md`.
2. Confirm current git branch and uncommitted changes.
3. Start from TODO section 4 integration tests or section 5 editor implementation unless priorities changed.
4. Keep interoperability with Obsidian as a hard requirement.
5. Update this vault with any major architecture decision.

## Session Context (2026-03-04)
- Planning artifacts created: `scope.md`, `TODO.md`.
- README updated with core requirement and planning links.
- Project setup scaffold implemented:
  - Nextcloud app structure and bootstrap files
  - CI workflow for lint/test/build
  - Frontend and PHP toolchains
  - contributor and developer setup docs
- Nextcloud runtime integration completed for app registration/routing.
- File API endpoints implemented:
  - `GET /apps/cloudwiki/api/file`
  - `PUT /apps/cloudwiki/api/file` with ETag conflict detection.
- Runtime smoke tests passed in Dockerized Nextcloud:
  - App enable/disable
  - Route registration
  - Page renders with `cloudwiki-main.js`
  - API open/save/conflict responses verified.

Related: [[Project_Overview]], [[Implementation_TODO]].
