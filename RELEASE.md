# Release Instructions

This package is distributed through [Packagist.org](https://packagist.org/packages/sqweb/sdk_php), for use with composer.

To release a new version, simply tag one in Git, and push it.

Make sure [CHANGELOG.MD](CHANGELOG.MD) is up to date.

To prepare a GitHub release, run `./build.sh`. This will create a zip for you in `build/`, which should be attached to the GitHub release. Don't forget to paste the contents of the changelog as well.