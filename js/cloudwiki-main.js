(() => {
	const root = document.getElementById('cloudwiki-root')
	if (!root) {
		return
	}

	const resolveApiBase = () => {
		if (window.OC?.generateUrl) {
			return window.OC.generateUrl('/apps/cloudwiki/api/file')
		}
		return '/index.php/apps/cloudwiki/api/file'
	}

	const getRequestToken = () => {
		if (typeof window.OC?.requestToken === 'string' && window.OC.requestToken.length > 0) {
			return window.OC.requestToken
		}

		const token = document.head?.dataset?.requesttoken
		if (typeof token === 'string' && token.length > 0) {
			return token
		}

		return null
	}

	const isValidMdPath = (path) => {
		const normalized = path.trim()
		if (normalized.length === 0) {
			return false
		}
		if (!normalized.toLowerCase().endsWith('.md')) {
			return false
		}
		return !normalized.includes('..') && !normalized.includes('\\')
	}

	const escapeHtml = (value) =>
		value
			.replaceAll('&', '&amp;')
			.replaceAll('<', '&lt;')
			.replaceAll('>', '&gt;')
			.replaceAll('"', '&quot;')
			.replaceAll("'", '&#39;')

	root.innerHTML = `
		<main class="cw-shell">
			<header class="cw-header">
				<h1>CloudWiki</h1>
				<p>Raw markdown editor with safe save (ETag conflict detection).</p>
			</header>

			<section class="cw-toolbar">
				<label for="cw-path">Path</label>
				<input id="cw-path" type="text" placeholder="Notes/Readme.md" spellcheck="false" />
				<button id="cw-open" type="button">Open</button>
				<button id="cw-save" type="button">Save</button>
			</section>

			<p id="cw-status" class="cw-status cw-status-idle">Ready.</p>

			<section class="cw-editor-wrap">
				<textarea
					id="cw-editor"
					class="cw-editor"
					placeholder="# Markdown note"
					spellcheck="false"
				></textarea>
			</section>
		</main>
	`

	const pathInput = root.querySelector('#cw-path')
	const editor = root.querySelector('#cw-editor')
	const statusEl = root.querySelector('#cw-status')
	const openButton = root.querySelector('#cw-open')
	const saveButton = root.querySelector('#cw-save')

	if (!pathInput || !editor || !statusEl || !openButton || !saveButton) {
		return
	}

	const apiBase = resolveApiBase()
	let currentEtag = null
	let hasUnsavedChanges = false
	let autosaveTimer = null

	const setStatus = (message, mode = 'idle') => {
		statusEl.className = `cw-status cw-status-${mode}`
		statusEl.textContent = message
	}

	const setBusy = (busy) => {
		pathInput.disabled = busy
		editor.disabled = busy
		openButton.disabled = busy
		saveButton.disabled = busy
	}

	const authHeaders = () => {
		const headers = {
			Accept: 'application/json',
			'X-Requested-With': 'XMLHttpRequest',
		}
		const requestToken = getRequestToken()
		if (requestToken) {
			headers.requesttoken = requestToken
		}
		return headers
	}

	const openNote = async () => {
		const path = pathInput.value.trim()
		if (!isValidMdPath(path)) {
			setStatus('Path must be a valid .md path with no traversal tokens.', 'error')
			return
		}

		setBusy(true)
		setStatus('Opening note...', 'idle')
		try {
			const url = `${apiBase}?path=${encodeURIComponent(path)}`
			const response = await fetch(url, {
				method: 'GET',
				headers: authHeaders(),
				credentials: 'same-origin',
			})

			const payload = await response.json().catch(() => ({}))
			if (!response.ok) {
				setStatus(`Open failed (${response.status}): ${payload.error || 'Unknown error'}`, 'error')
				return
			}

			editor.value = typeof payload.content === 'string' ? payload.content : ''
			currentEtag = typeof payload.etag === 'string' ? payload.etag : null
			hasUnsavedChanges = false
			setStatus(
				`Opened ${path} (etag ${escapeHtml(currentEtag || 'n/a')}, mtime ${payload.mtime || 'n/a'}).`,
				'success',
			)
		} catch (error) {
			setStatus(`Open failed: ${error instanceof Error ? error.message : 'Network error'}`, 'error')
		} finally {
			setBusy(false)
		}
	}

	const saveNote = async (isAutosave = false) => {
		const path = pathInput.value.trim()
		if (!isValidMdPath(path)) {
			setStatus('Path must be a valid .md path with no traversal tokens.', 'error')
			return
		}

		if (isAutosave && !hasUnsavedChanges) {
			return
		}

		setBusy(true)
		setStatus(isAutosave ? 'Autosaving note...' : 'Saving note...', 'idle')
		try {
			const response = await fetch(apiBase, {
				method: 'PUT',
				headers: {
					...authHeaders(),
					'Content-Type': 'application/json',
				},
				credentials: 'same-origin',
				body: JSON.stringify({
					path,
					content: editor.value,
					expectedEtag: currentEtag,
				}),
			})

			const payload = await response.json().catch(() => ({}))
			if (response.status === 409 || response.status === 412) {
				currentEtag = typeof payload.currentEtag === 'string' ? payload.currentEtag : currentEtag
				const remoteMtime = payload.currentMtime ? ` (remote mtime ${payload.currentMtime})` : ''
				setStatus(
					`Save conflict: file changed remotely. Reload before saving again${remoteMtime}.`,
					'warn',
				)
				return
			}
			if (!response.ok) {
				setStatus(`Save failed (${response.status}): ${payload.error || 'Unknown error'}`, 'error')
				return
			}

			currentEtag = typeof payload.etag === 'string' ? payload.etag : currentEtag
			hasUnsavedChanges = false
			setStatus(
				`${isAutosave ? 'Autosaved' : 'Saved'} ${path} (etag ${escapeHtml(currentEtag || 'n/a')}).`,
				'success',
			)
		} catch (error) {
			setStatus(`Save failed: ${error instanceof Error ? error.message : 'Network error'}`, 'error')
		} finally {
			setBusy(false)
		}
	}

	const scheduleAutosave = () => {
		if (autosaveTimer !== null) {
			clearTimeout(autosaveTimer)
		}
		autosaveTimer = window.setTimeout(() => {
			void saveNote(true)
		}, 1200)
	}

	openButton.addEventListener('click', () => {
		void openNote()
	})
	saveButton.addEventListener('click', () => {
		void saveNote()
	})
	editor.addEventListener('input', () => {
		hasUnsavedChanges = true
		setStatus('Unsaved changes...', 'warn')
		scheduleAutosave()
	})
	pathInput.addEventListener('keydown', (event) => {
		if (event.key === 'Enter') {
			event.preventDefault()
			void openNote()
		}
	})
	document.addEventListener('keydown', (event) => {
		if (!(event.metaKey || event.ctrlKey)) {
			return
		}

		const key = event.key.toLowerCase()
		if (key === 's') {
			event.preventDefault()
			void saveNote()
			return
		}

		if (key === 'o') {
			event.preventDefault()
			pathInput.focus()
			pathInput.select()
		}
	})
	window.addEventListener('beforeunload', (event) => {
		if (!hasUnsavedChanges) {
			return
		}
		event.preventDefault()
		event.returnValue = ''
	})
})()
