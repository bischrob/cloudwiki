import { describe, expect, it } from 'vitest'

function extractWikiLinks(input: string): string[] {
  const matches = input.matchAll(/\[\[([^\]]+)\]\]/g)
  return Array.from(matches, (match) => match[1])
}

describe('extractWikiLinks', () => {
  it('extracts wikilinks from markdown text', () => {
    const links = extractWikiLinks('Start [[Note One]] and [[Another/Path]] end')
    expect(links).toEqual(['Note One', 'Another/Path'])
  })
})
