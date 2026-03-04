# cloudwiki

CloudWiki is a Nextcloud app for fast raw Markdown note editing with Obsidian-style `[[wikilinks]]`, backlinks, and native Nextcloud permissions/sharing/version behavior.

## Core Requirement
CloudWiki must support interoperable editing with Obsidian when both point to the same Nextcloud-synced folder: a user can edit a note in Obsidian and then edit that same note in CloudWiki (and vice versa) without conversion or lock-in.

## Planning Docs
- [Scope](./scope.md)
- [TODO](./TODO.md)

## MVP Focus
- Raw markdown editor (no live preview)
- Wikilink suggestions, navigation, and note creation
- Backlinks panel
- Nextcloud-native auth, ACL, and file handling
