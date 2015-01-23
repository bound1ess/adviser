# Adviser [![Build Status](https://travis-ci.org/bound1ess/adviser.svg?branch=master)](https://travis-ci.org/bound1ess/adviser)

Adviser is a CLI application written in PHP that checks your project for various possible improvements. Heavily inspired by [phppackagechecklist.com](http://phppackagechecklist.com).

## What It Does

### PHP package

1. Check that the current directory is a Git repository.
    - The `remote.origin.url` property should point to either **Github** or **Bitbucket**.
2. Check that the `composer.json` manifest file is present and valid.
    - Check for a PSR-4 autoloader.
    - Check if your project is available on [Packagist](https://packagist.org).
    - Extra: ensure that the source code is being stored in `src/`.
3. Check if your project is framework agnostic or not.
4. Check the source code using [PHP Code Sniffer](https://github.com/squizlabs/PHP_CodeSniffer).
5. Check for tests folder and a proper testing framework configuration.
    - Support for **PhpSpec**, **PHPUnit**, **Behat**, **Codeception**.
6. Check for CI (Continuous Integration) configuration file.
    - [Travis](https://travis-ci.org) is supported.
7. Check for [SemVer](http://semver.org) support.
8. Check for a [changelog](http://keepachangelog.com) file of some sort.
9. Check for a [license](http://choosealicense.com) file.
10. Check for a CONTRIB(UTING) file.
11. Check for a README file.

## Progress

### Utility classes

- `Git`:
    - `getTags` [x]
    - `isRepository` [x]
    - `getConfig` [ ]
- `CommandRunner`
    - `run` [x]
- `Packagist`
    - `packageExists` [ ]

### Validators

@todo

## License

This project is licensed under [the MIT license](https://github.com/bound1ess/adviser/blob/master/LICENSE).
