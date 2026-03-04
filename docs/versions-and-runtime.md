# CloudWiki Versions and Runtime Targets

## Baseline Targets
- Nextcloud: `33.x` (current tested target)
- PHP: `8.4.x`
- Node.js: `20.x` (LTS line used for frontend/build tooling)

## Compatibility Policy
- Primary support target is the Nextcloud major listed in `appinfo/info.xml`.
- PHP and Node baselines track the lowest stable versions used in CI and local dev docs.
- Version bumps must be reflected in:
  - `appinfo/info.xml` dependencies
  - this document
  - `README.md` quick start

## Validation Checklist for Runtime Updates
- Confirm app routing and bootstrapping still load.
- Re-run API smoke tests (`open`, `save`, conflict path).
- Re-run frontend build + lint + tests.
- Re-run dockerized Nextcloud manual verification for app navigation and editing.
