# Adviser [![Build Status](https://travis-ci.org/bound1ess/adviser.svg?branch=master)](https://travis-ci.org/bound1ess/adviser)

Adviser is a CLI application that checks your PHP project for various possible improvements.

Heavily inspired by [phppackagechecklist.com](http://phppackagechecklist.com).

## Navigation

- [Installing](#installing)
- [Using](#using)
- [Configuring](#configuring)
- [Extending](#extending)
- [Additional information](#additional-information)

## Installing

### Composer way

Just run in your terminal (you should be in your project's root directory):

```shell
composer require --dev bound1ess/adviser
```

Or, if you don't have *Composer* installed globally:

```shell
curl -sS https://getcomposer.org/installer | php
./composer.phar require --dev bound1ess/adviser
```


Now you should be able to run `vendor/bin/adviser` and see something like this:
![](http://i.imgur.com/rNT39gP.png)

### Building a PHAR

This is not very difficult to do either, just run:

```shell
git clone https://github.com/bound1ess/adviser.git
cd adviser
composer update # Assuming that it's installed globally.
make build-phar
```

Now you can just run `builds/adviser.phar`, or (only if you want to!) you can also do this:

```shell
sudo mv builds/adviser.phar /usr/local/bin/adviser
```

Now you can use `adviser` (everywhere!) instead of `builds/adviser.phar`:
![](http://i.imgur.com/JUXDdhz.png)

## Using

...

## Configuring

...

## Extending

...

## Additional information

License and support information, as well as my thanks to everyone who made *Adviser* possible.

### License

This project is licensed under *the MIT license*.

### Support

Stuck?
Found a bug?
Feel free to create a new issue here on *Github*, or find me on [Twitter](https://twitter.com/bound1ess).

### Thanks!

To the creators of *PHPUnit*, *Symfony*, *Guzzle*, *Mockery* and *Box* projects.
