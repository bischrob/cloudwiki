# CloudWiki TODO

## 1. Scope and Foundation
- [ ] Approve `scope.md` with all stakeholders.
- [ ] Confirm target Nextcloud version(s) and PHP/Node versions.
- [ ] Define release strategy for internal alpha -> beta -> v1.

## 2. Project Setup
- [ ] Create Nextcloud app skeleton (`appinfo`, `lib`, `src`, `templates`, `tests`).
- [ ] Add tooling: lint, format, typecheck, unit test commands.
- [ ] Add CI workflow for lint + tests + packaging.
- [ ] Add contribution and local dev setup docs.

## 3. App Registration and Routing
- [ ] Implement `appinfo/info.xml` metadata.
- [ ] Bootstrap app in `lib/AppInfo/Application.php`.
- [ ] Register navigation entry and editor routes.
- [ ] Add permissions and capability declarations required by Nextcloud.

## 4. File Open/Save (Core Editor Path)
- [ ] Add endpoint to open/load markdown content by file id/path.
- [ ] Add endpoint to save markdown content with conflict detection.
- [ ] Enforce ETag/mtime-based stale write protection.
- [ ] Add integration tests for successful save and conflict responses.

## 5. Raw Markdown Editor UI
- [ ] Integrate CodeMirror 6 in single-pane mode.
- [ ] Add keyboard shortcuts: save, open link, create note.
- [ ] Add autosave (debounced) and visible save status.
- [ ] Add unsaved-changes navigation guard.

## 6. Wikilinks
- [ ] Parse and highlight `[[wikilink]]` tokens in editor text.
- [ ] Provide autocomplete suggestions for note targets.
- [ ] Enable click/Ctrl+click link navigation.
- [ ] Support unresolved-link create flow.
- [ ] Define and implement link normalization rules.

## 7. Indexing and Backlinks
- [ ] Create DB schema for derived link index cache.
- [ ] Build initial full markdown scan job.
- [ ] Build incremental reindex on changed files.
- [ ] Implement backlinks query endpoint.
- [ ] Add backlinks side panel in editor.

## 8. Nextcloud-Native Integration
- [ ] Enforce ACL checks in all file and index APIs.
- [ ] Ensure shared-folder behavior works for read/write users.
- [ ] Preserve compatibility with Nextcloud versions/history.
- [ ] Add audit logging for key file/index actions.

## 9. Obsidian Interoperability
- [ ] Validate round-trip editing between Obsidian and CloudWiki.
- [ ] Ensure plain markdown persistence with no proprietary wrappers.
- [ ] Test wikilink compatibility with Obsidian-style syntax.
- [ ] Add conflict scenario tests for external (Obsidian) edits.

## 10. Security and Reliability
- [ ] Add CSRF protections on all mutating endpoints.
- [ ] Add strict input/path validation and traversal prevention.
- [ ] Add endpoint throttling where appropriate.
- [ ] Add robust error handling and structured logs.

## 11. Testing and Performance
- [ ] Unit tests for wikilink parser and normalizer.
- [ ] Unit tests for index build/update behavior.
- [ ] Integration tests for permissions and shared folders.
- [ ] UI tests for wikilink suggestion/create/open flows.
- [ ] Performance benchmark on larger note sets.

## 12. Docs and Release
- [ ] Expand README with architecture and quick start.
- [ ] Add admin config and user guide docs.
- [ ] Add migration notes for schema/index changes.
- [ ] Build and sign release artifact.
- [ ] Tag and publish `v0.1.0` MVP milestone.
