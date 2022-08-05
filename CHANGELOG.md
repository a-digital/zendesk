# Zendesk Changelog

## 2.0.0 - 2022-08-05
### Added
- Craft 4 version released

## 1.0.10 - 2020-11-24
### Changed
- Updated plugin logo

## 1.0.9 - 2020-11-04
### Fixed
- Asset bundle sourcePath not correctly defined since 1.0.7


## 1.0.8 - 2020-11-03
### Changed
- Merged [devinellis](https://github.com/devinellis) pull request - Zendesk error response now throws an exception

## 1.0.7 - 2020-11-03
### Fixed
- Composer 2 compatibility - Asset bundle PSR-4 autoloading standard

## 1.0.6 - 2018-11-02
### Fixed
- Issue with ticket submission when attachments field was left blank

## 1.0.5 - 2018-08-01
### Fixed
- Updated icon mask file as it was previously missing

## 1.0.4 - 2018-07-26
### Fixed
- Undefined index: customFields error is now resolved

## 1.0.3 - 2018-07-02
### Added
- File upload functionality added to dashboard widget

## 1.0.2 - 2018-06-29
### Added
- File upload functionality added to front end form, add files using `attachments[]` in upload field names

### Changed
- Updated readme file example code to include file upload fields

## 1.0.1 - 2018-06-26
### Fixed
- Errors related to missing zendesk.php config file if not created

### Added
- Allow body inputs on the frontend form to submit as arrays e.g. `body[]`
- Body arrays can now have defined keys `body[requestName]`
- Conditionals around body formatting to display arrays as `key: value` on separate lines for each item

## 1.0.0 - 2018-01-03
### Added
- Initial release

Brought to you by [A Digital](https://adigital.agency)
