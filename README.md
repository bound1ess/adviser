# Adviser [![Build Status](https://travis-ci.org/bound1ess/adviser.svg?branch=master)](https://travis-ci.org/bound1ess/adviser)

Adviser is a CLI application that checks your PHP project for various possible improvements.

Heavily inspired by [phppackagechecklist.com](http://phppackagechecklist.com).

## Status

Active development, around 75% of work is already done for the first stable release.

### @todo

- Add various output formatters (plain text).
- Write documentation.
- Add examples of work (output).

## What It Does

1. Checks that the current directory is a Git repository.
    - The `remote.origin.url` property should point to either **Github** or **Bitbucket**.

2. Checks for [SemVer](http://semver.org) tags.

3. Checks for a [changelog](http://keepachangelog.com) file of some sort.

4. Checks for a [license](http://choosealicense.com) file.

5. Checks for a README file.

6. Checks for a CONTRIB(UTING) file.

7. Checks if your project is framework agnostic or not.

8. Checks for tests folder and a proper testing framework configuration.
    - Support for **PhpSpec**, **PHPUnit**, **Behat**, **Codeception**.

9. Checks for CI (Continuous Integration) configuration file.
    - [Travis](https://travis-ci.org) is supported.

10. Checks that the `composer.json` manifest file is present and valid.
    - Checks for a PSR-4 autoloader.
    - Checks if your project is available on [Packagist](https://packagist.org).
    - Checks that the source code is being stored in `src/`.

11. Checks the source code using [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer).

## License

This project is licensed under [the MIT license](https://github.com/bound1ess/adviser/blob/master/LICENSE).
