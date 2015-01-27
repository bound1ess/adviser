# Adviser [![Build Status](https://travis-ci.org/bound1ess/adviser.svg?branch=master)](https://travis-ci.org/bound1ess/adviser)

Adviser is a CLI application written in PHP that checks your project for various possible improvements. Heavily inspired by [phppackagechecklist.com](http://phppackagechecklist.com).

## What It Does

### PHP package

#### Done

1. Check that the current directory is a Git repository.
    - The `remote.origin.url` property should point to either **Github** or **Bitbucket**.

2. Check for [SemVer](http://semver.org) tags.

3. Check for a [changelog](http://keepachangelog.com) file of some sort.

4. Check for a [license](http://choosealicense.com) file.

5. Check for a README file.

6. Check for a CONTRIB(UTING) file.

7. Check if your project is framework agnostic or not.

8. Check for tests folder and a proper testing framework configuration.
    - Support for **PhpSpec**, **PHPUnit**, **Behat**, **Codeception**.

9. Check for CI (Continuous Integration) configuration file.
    - [Travis](https://travis-ci.org) is supported.

10. Check that the `composer.json` manifest file is present and valid.
    - Check for a PSR-4 autoloader.
    - Check if your project is available on [Packagist](https://packagist.org).
    - Ensure that the source code is being stored in `src/`.

11. Check the source code using [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer).

## Progress

Around `50%`.

### Utility

- `Git`:
    - `getTags` [x]
    - `isRepository` [x]
    - `getConfig` [x]
- `CommandRunner`:
    - `run` [x]
- `Packagist`:
    - `packageExists` [x]
- `Composer`:
    - `readManifest` [x]
    - `manifestExists` [x]
    - `isManifestValid` [x]
    - `hasAutoloader` [x]
    - `getSourceDirectories` [x]
    - `getDependencies` [x]
- `File`:
    - `exists` [x]
    - `anyExists` [x]

### Messages

- `Message` [x]
- `MessageBag` [x]

### Validators

- `AbstractValidator` [x]
- `ValidatorLoader` [x]
- `GitValidator` [x]
- `ComposerValidator` [x]
- `FrameworkValidator` [x]
- `CodeStyleValidator` [ ]
- `TestValidator` [x]
- `CIValidator` [x]
- `SemVerValidator` [x]
- `ReadmeValidator` [x]
- `LicenseValidator` [x]
- `ContributingValidator` [x]
- `ChangelogValidator` [x]

## License

This project is licensed under [the MIT license](https://github.com/bound1ess/adviser/blob/master/LICENSE).
