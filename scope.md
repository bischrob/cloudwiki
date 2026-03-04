# CloudWiki Scope

## Product Statement
CloudWiki is a Nextcloud app that provides a fast raw Markdown editing experience with wiki-style linking for notes stored in Nextcloud.

## Goals
- Open, edit, and save `.md` files directly in Nextcloud.
- Support Obsidian-style `[[wikilinks]]` with note lookup and creation.
- Expose backlinks for the current note.
- Enforce Nextcloud-native authentication, permissions, sharing, and file/version behavior.
- Maintain interoperability with Obsidian when both tools point to the same Nextcloud-synced folder.

## Required Interoperability
A user must be able to edit files in Obsidian linked to a Nextcloud folder and then edit the same files in CloudWiki without format breakage or lock-in.

### Interoperability Acceptance Notes
- CloudWiki stores notes as plain `.md` files only.
- CloudWiki does not add proprietary wrappers around note content.
- Wikilink syntax remains compatible with Obsidian-style `[[...]]` links.
- External edits (including Obsidian) are detected and handled safely on save.

## In Scope (MVP)
- Raw Markdown editor (single pane, no live preview).
- Open-in-editor action for `.md` files from Nextcloud Files.
- File load/save APIs with conflict detection.
- Wikilink parsing + autocomplete.
- Open existing wikilink target.
- Create note from unresolved wikilink.
- Backlinks panel from indexed links.
- Incremental markdown index for link suggestions/backlinks.
- Respect Nextcloud ACLs in all read/write/index operations.

## Out of Scope (MVP)
- Markdown preview renderer.
- Graph view.
- Plugin marketplace/ecosystem.
- Non-markdown rich-text formats.
- Full Obsidian parity beyond markdown + wikilinks interoperability.

## Key User Stories
- As a user, I can open any markdown file in CloudWiki from Nextcloud Files.
- As a user, I can type `[[` and get matching note suggestions.
- As a user, I can follow a wikilink to open another note.
- As a user, I can create a missing target note from an unresolved wikilink.
- As a user, I can see backlinks to the current note.
- As a user, I can edit a note in Obsidian and continue editing it in CloudWiki.

## Acceptance Criteria
- `.md` files show an `Open in CloudWiki` action.
- Save operation updates the same file path in Nextcloud storage.
- Save rejects stale writes when the file changed externally since last load.
- Wikilink suggestion appears while typing `[[...` and returns matching notes.
- Selecting a suggestion inserts/updates a valid wikilink token.
- Opening a wikilink navigates to the resolved note when it exists.
- Unresolved wikilink supports creating a new `.md` note in configured/default folder.
- Backlinks endpoint returns notes that link to the active note.
- Permission checks block unauthorized read/write/index access.
- Notes edited in Obsidian remain readable/editable in CloudWiki without conversion.

## Non-Functional Requirements
- Fast typing and save UX for typical note sizes.
- Deterministic link resolution behavior.
- Rebuildable index (derived cache only).
- No vendor-specific markdown extensions required for core behavior.
