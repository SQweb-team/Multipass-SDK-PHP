# Changelog

## v1.5.7 - 2017-06-08

* Added a new function to display a support block.
* Added a new function to display a locking block.

## v1.5.6 - 2017-05-26

* Added linebreaks cleanup to config file parser.

## v1.5.5 - 2017-05-24

* Fixed broken `explode()` in `sqweb_config.php` configuration option.

## v1.5.4 - 2017-05-23

* Fixed array syntax, for unsupported PHP versions.

## v1.5.3 - 2017-05-16

* Fixed typo in error message.
* Improved deployment automation.

## v1.5.2 - 2017-05-16

* Updated API endpoint to Multipass.net.

## v1.5.1 - 2017-05-16

* Introduced `SQW_ADBLOCK_MODAL` configuration variable.
* Updated CDN endpoint to Multipass.net.
* Fixed `_sqw.sitename` in config object (must be quoted).

## v1.5.0 - 2016-11-25

* Added `tiny` and `large` options for the Multipass button.
* Introduced `SQW_SITENAME` variable in our configuration file.
* Normalized variables names with our other SDKs.
* Leaner build system (replaced `gulp` with a shell script).

## v1.4.2 - 2016-11-01

* Added the option to display a smaller button.

## v1.4.1 - 2016-10-31

* Updated client script URL (now HTTPS only).

## v1.4 - 2016-10-11

* Fix bad call to sqwBalise

## v1.3 - 2016-09-23

* Added `transparent()` function to hide a part of your content.
* Added `limitArticle()` function to limit the number of articles read a day by free users.
* Added `waitToDisplay()` function to make the articles display later for free users.
* Readme improvements.

## v1.2 - 2016-06-07

* Improved `.env` handling.
* Added configuration via array.

## v1.1 - 2016-05-24

* Introduced autoloader support via Composer.
* Introduced `.env` configuration.
* Simplified manual installation.

## v1.0.4 - 2015-12-04

* Added versioning to Curl User Agent.

## v1.0.3 - 2015-12-03

* Improved documentation (Readme + comments).
* Added Gulp tasks for packaging.
* Updated Travis configuration.
* Clarified licensing.
* Added Changelog.

## v1.0.2 - 2015-11-27

* Updated the configuration to allow custom message definition.

## v1.0.1 - 2015-11-27

* Readme improvements.

## v1.0.0 - 2015-11-24

* Initial release.
