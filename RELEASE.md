# Release Instructions

This package is distributed through [Packagist.org](https://packagist.org/packages/sqweb/sdk_php), for use with composer.

To prepare a GitHub release, run `./build.sh`. This will create a zip for you in `build/`.

To release a new version :

1. Make sure [CHANGELOG.md](CHANGELOG.md) is up to date.
2. Tag a release in Git, using the following naming scheme `v1.5.0`.
3. Push the tag.

**Travis will automatically create a new release, and upload the ZIP to GitHub.** Don't forget to paste the contents of the changelog in the release details.
