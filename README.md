SQweb - PHP SDK
===

[![Build Status](https://travis-ci.org/SQweb-team/SQweb-SDK-PHP.svg?branch=master)](https://travis-ci.org/SQweb-team/SQweb-SDK-PHP)
[![Code Climate](https://codeclimate.com/github/SQweb-team/SQweb-SDK-PHP/badges/gpa.svg)](https://codeclimate.com/github/SQweb-team/SQweb-SDK-PHP)
[![Latest Stable Version](https://poser.pugx.org/sqweb/sdk_php/v/stable)](https://packagist.org/packages/sqweb/sdk_php)
[![License](https://poser.pugx.org/sqweb/sdk_php/license)](https://packagist.org/packages/sqweb/sdk_php)
[![Dependency Status](https://www.versioneye.com/user/projects/5650b42bff016c002c00056f/badge.svg)](https://www.versioneye.com/user/projects/5650b42bff016c002c00056f)

##Requirements

**This SDK has been tested with PHP 5.5 and greater.**

We are unable to provide official support for earlier versions. For more information about end of life PHP branches, [see this page](http://php.net/supported-versions.php).

##Install

**This package is intended for custom PHP websites and advanced integrations.**

If you're using WordPress, we've made it easy for you. Download the SQweb plugin [directly from WordPress.org](https://wordpress.org/plugins/sqweb/), or check out the source [here](https://github.com/SQweb-team/SQweb-WordPress-Plugin).

###Using Composer and dotenv (Recommended)

1. In your project root, execute `composer require sqweb/sdk_php` ;
2. Create a file named `.env` at the root of your project, or edit it if you already have one.
3. In `.env`, paste the following configuration and **set the variable `SQW_ID_SITE` with your website ID**:
```php
<?php
SQW_ID_SITE=YOUR_WEBSITE_ID
?>
```
For additional settings, see "[Options](#options)" below.

###Using Composer and manual

1. `composer require sqweb/sdk_php`
2. Create a new SQweb object passing in its configuration through the constructor. **`SQW\_ID\_SITE` must be specified**.

```php
<?php
require_once('vendor/autoload.php');
$sqweb = new \SQweb\SQweb(['SQW_ID_SITE' => 1234, 'SQW_MESSAGE' => 'Please support my site']);
?>
```

For additional settings, see "[Options](#options)" below.

###Manually

1. Download the latest release of the SDK [from here](https://github.com/SQweb-team/SQweb-SDK-PHP/releases) and unzip it in a folder named `sqweb` in your project root.
2. Create a file named `sqweb_config.php` at the root of your project.

This file should be one level up from the sqweb folder you just created, i.e. :

```
|–- sqweb/
|	|-- src/
|	|	|-- init.php
|	|	|-- SQweb.php
|-- sqweb_config.php
```

3. In `sqweb_config.php`, paste the following configuration and **set the variable `SQW_ID_SITE` with your website ID**:

```php
<?php
SQW_ID_SITE=YOUR_WEBSITE_ID
?>
```

For additional settings, see "[Options](#options)" below.

##Usage

###1. Initializing the SDK

You have to initialise the SQweb variable on the pages where you need it with this piece of code:

If you used composer:
```php
<?php
$sqweb = new SQweb\SQweb;
?>
```

If you installed manually:
```php
<?php
include_once "whereYouInstalled/src/init.php";
?>
```

###2. Tagging your pages

This function outputs the SQweb JavaScript tag. Insert it before the closing `</body>` tag in your HTML.

```php
<?php
$sqweb->script();
?>
```

Make sure it is present on all your pages. Most likely you'll just have to add it to your template.

**If you previously had a SQweb JavaScript tag, make sure to remove it to avoid any conflicts.**

###3. Checking the credits of your subscribers

This function checks if the user has credits, so that you can disable ads and/or unlock premium content.

You can use it like this :

```php
<?php
if ($sqweb->checkCredits() > 0) {
    //CONTENT
} else {
    //ADS
}
?>
```

###4. Showing the Multipass button

Finally, use this code to get the Multipass button on your pages:

```php
<?php
$sqweb->button();
?>
```

We have a smaller version of the button, to use it, pass the string 'slim' to the function e.g:

```php
<?php
$sqweb->button('slim');
?>
```

###5. More functions

1.This function is used to display only a part of your content to non premium users:
```php
<?php
function transparent($your_content, $percent) { ... }
?>
```
`$percent` is the percent of your content you want to display to everyone.

Example:
```php
<?php
echo transparent('one two three four', 50);
?>
```
Will display for free users:
```
one two
```

2.The following function is used to display your content later for non paying users:
```php
<?php
function waitToDisplay($publication_date, $date_format, $wait) { ... }
?>
```
`$publication_date` is the date when your content is published on your website.
`$date_format` is the format of your publication date ('Y-m-d' for '2016-12-18').
`$wait` is the number of day you want to wait before showing this content to free users.

Example:
```php
<?php
if (waitToDisplay('15/09/16', 'd/m/y', 2)) {
	The content here will appear 2 days after the publication date for non paying users.
} else {
	Here you can put content that free users will see before the content above is available for all.
}
?>
```

3.The next function is used to limit the number of articles free users can read a day:
```php
<?php
function limitArticle($number_of_articles) { ... }
?>
```
`$number_of_articles` is the number of articles a free user can see.

Example if I want to display only 5 articles to free users:
```php
<?php
if (limitArticle(5) == true) {
	echo "This is my article";
} else {
	echo "Sorry, you reached the limit of pages you can see today, come back tomorrow or subscribe to Multipass to get unlimited articles !";
}
?>
```

##Options

Unless otherwise noted, these options default to `false`. You can set them in your configuration.

|Option|Description
|---|---|
|`SQW_MESSAGE`|A custom message that will be shown to your adblockers. If using quotes, you must escape them.|
|`SQW_TARGETING`|Only show the button to detected adblockers. Cannot be combined with the `beacon` mode.|
|`SQW_BEACON`|Monitor adblocking rates quietly, without showing a SQweb button or banner to the end users.|
|`SQW_DEBUG`|Output various messages to the browser console while the plugin executes.|
|`SQW_DWIDE`|Set to `false` to only enable SQweb on the current domain. Defaults to `true`.|
|`SQW_LANG`|You may pick between `en` and `fr`.|


##Contributing

We welcome contributions and improvements.

###Coding Style

All PHP code must conform to the [PSR2 Standard](http://www.php-fig.org/psr/psr-2/).

###Builds and Releases

Releases are handled with `gulp`. To package a release of the SDK, simply execute `gulp`. This will prepare a zip for you in `dist/`.

By default, the `build/` folder is automatically removed. If you want to keep it, say for debugging, you can package the SDK using `gulp keep-build`.

##Bugs and Security Vulnerabilities

If you encounter any bug or unexpected behavior, you can either report it on Github using the bug tracker, or via email at `hello@sqweb.com`. We will be in touch as soon as possible.

If you discover a security vulnerability within SQweb or this plugin, please send an e-mail to `hello@sqweb.com`. All security vulnerabilities will be promptly addressed.

##License

Copyright (C) 2015 – SQweb

This program is free software ; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation ; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY ; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details

You should have received a copy of the GNU General Public License along with this program.  If not, see <http://www.gnu.org/licenses/>.