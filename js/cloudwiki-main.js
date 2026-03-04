(() => {
  const root = document.getElementById('cloudwiki-root')
  if (!root) {
    return
  }

  root.innerHTML = `
    <main style="padding:16px;">
      <h1 style="margin:0 0 8px; font-size:1.5rem;">CloudWiki</h1>
      <p style="margin:0;">App shell loaded. File API endpoints are available at <code>/apps/cloudwiki/api/file</code>.</p>
    </main>
  `
})()
