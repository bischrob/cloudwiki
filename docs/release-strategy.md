# CloudWiki Release Strategy

## Stages
1. Internal Alpha (`0.1.0-alpha.x`)
2. Beta (`0.1.0-beta.x`)
3. Stable v1 (`1.0.0`)

## Internal Alpha Exit Criteria
- App loads from Nextcloud navigation without CSRF/auth regressions.
- Raw markdown open/save works for existing `.md` files.
- Stale-write detection returns a conflict response and clear UI feedback.
- Core docs exist for local setup and contribution workflow.

## Beta Exit Criteria
- Wikilink parsing/autocomplete/navigation implemented.
- Backlinks indexing and UI panel implemented.
- Permission + shared-folder behavior tested.
- Test suite covers API happy path and conflict path.

## v1 Exit Criteria
- Obsidian round-trip editing verified for representative vault structures.
- Security hardening checklist complete.
- Performance sanity checks completed for larger note sets.
- Release artifact built, signed, tagged, and documented.

## Release Operations
- Branch strategy: `main` + short-lived feature branches.
- Each release candidate is tagged in GitHub.
- Changelog entries are required per release candidate.
