SDK SQweb
===

[![Build Status](https://travis-ci.org/SQweb-team/SQweb-SDK-PHP.svg)](https://travis-ci.org/SQweb-team/SQweb-SDK-PHP)
[![Code Climate](https://codeclimate.com/github/SQweb-team/SQweb-SDK-PHP/badges/gpa.svg)](https://codeclimate.com/github/SQweb-team/SQweb-SDK-PHP)

##Install

1. Download the SDK and add it to your site folder ;
2. Define your Website ID and User ID in `config.php` ;
3. Include the SDK in all pages where you need use it.

```php
include_once 'sqweb-php-sdk/init.php';
```

##Usage

The SDK is super basic. Here's how to use it :

###1. Tagging your pages

This function outputs the SQweb JavaScript tag. Insert it before the closing `</body>` tag in your HTML.

```php
$sqweb->sqwebScript();
```

Make sure it is present on all your pages. Most likely you'll just have to add it to your template.

###2. Checking the credits of your subscribers

This function checks if the user has credits, so that you can disable ads and/or unlock premium content.

You can use it like this :

```php
if ($sqweb->sqwebCheckCredits() > 0) {
    //CONTENT
} else {
    //ADS
}
```

###3. Showing the SQweb button

Finally, use this code to get the SQweb button on your pages:

```php
$sqweb->sqwebButton('blue');
```

This function takes one optional parameter, the color. You can switch between `blue` (default) and `grey`.
