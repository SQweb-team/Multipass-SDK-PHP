SDK SQweb
===

[![Build Status](https://travis-ci.org/SQweb-team/SQweb-SDK-PHP.svg)](https://travis-ci.org/SQweb-team/SQweb-SDK-PHP)
[![Code Climate](https://codeclimate.com/github/SQweb-team/SQweb-SDK-PHP/badges/gpa.svg)](https://codeclimate.com/github/SQweb-team/SQweb-SDK-PHP)

##Install

###Using Composer (Recommended)

1. `composer require sqweb/sdk_php` ;
2. Define your Website ID and User ID in `vendor/sqweb/sdk_php/src/init.php`.

###Manually

1. Download the SDK and add it to your site folder ;
2. Define your Website ID and User ID in `config.php` ;
3. Include the SDK in all pages where you need use it.

```php
include_once 'sqweb-php-sdk/init.php';
```

###WordPress

If you're using WordPress, we've made it easy for you. You can download the SQweb plugin [directly from WordPress.org](https://wordpress.org/plugins/sqweb/), or check out the source [here](https://github.com/SQweb-team/SQweb-WordPress-Plugin).


##Usage

The SDK is super basic. Here's how to use it :

###1. Tagging your pages

This function outputs the SQweb JavaScript tag. Insert it before the closing `</body>` tag in your HTML.

```php
$sqweb->script();
```

Make sure it is present on all your pages. Most likely you'll just have to add it to your template.

###2. Checking the credits of your subscribers

This function checks if the user has credits, so that you can disable ads and/or unlock premium content.

You can use it like this :

```php
if ($sqweb->checkCredits() > 0) {
    //CONTENT
} else {
    //ADS
}
```

###3. Showing the SQweb button

Finally, use this code to get the SQweb button on your pages:

```php
$sqweb->button('blue');
```

This function takes one optional parameter, the color. You can switch between `blue` (default) and `grey`.
