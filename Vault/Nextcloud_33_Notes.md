# Nextcloud 33 Notes

## Compatibility
- Server version in Docker: Nextcloud `33.0.0`.
- `appinfo/info.xml` must allow max-version `33` or app enable fails.

## Bootstrap Requirement
- `appinfo/app.php` is deprecated in Nextcloud 33 and creates repeated log warnings.
- Use `lib/AppInfo/Application.php` implementing `IBootstrap`.
- Load frontend assets from controller (`Util::addScript`, `Util::addStyle`).

## CLI Smoke Testing Pattern
- Basic auth with app password works for app routes when adding header:
  - `OCS-APIRequest: true`
- Useful for non-browser smoke tests of app pages and APIs.

## Verified Endpoints
- `GET /apps/cloudwiki/`
- `GET /apps/cloudwiki/api/file?path=Readme.md`
- `PUT /apps/cloudwiki/api/file` with `expectedEtag` conflict handling.

Related: [[Implementation_TODO]], [[Resumption_Checklist]].
