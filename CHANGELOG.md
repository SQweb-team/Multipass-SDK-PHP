# Changelog

## v1.7.6 - 2018-07-17

* Added the free button

## v1.7.5 - 2018-04-16

* Fixed some typos.

## v1.7.4 - 2018-03-05

* Improved the way we log actions with the support

## v1.7.3 - 2018-03-01

* Fixed a wrong variable name.

## v1.7.2 - 2018-02-28

* Added a tunnel option.

## v1.7.1 - 2018-01-15

* Renamed the package from SQweb to Multipass

## v1.7.0 - 2018-01-09

* Now support more locales.
* Added autologin feature.
* Reworked script method.

## v1.6.2 - 2017-11-20

* Added a sqweb.config.example in assets directory.
* Now passing click event when opening iframe.

## v1.6.1 - 2017-11-07

* Implemented a 'support us' version of the login button.
* Made all logins button's text customizable.

## v1.6.0 - 2017-07-19

* BREAKING : Renamed misleading `sqweb_config.php` to `sqweb.config`.
* Added exemples pages which are also tests.

## v1.5.9 - 2017-07-11

* Fixed a typo in css.

## v1.5.8 - 2017-07-05

* Replaced the support block with a "Support us" message.

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
