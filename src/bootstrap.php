<?php

if ( ! defined("ADVISER_DIR")) {
    define("ADVISER_DIR", __DIR__."/..");
}

// This function attempts to load Composer's autoloader.
function findComposerAutoloader() {
    if (file_exists($path = ADVISER_DIR."/vendor/autoload.php")) {
        return require $path;
    }
}

// This function returns Adviser's current version value.
function getAdviserVersion() {
    $config = require ADVISER_DIR."/config.php";

    return $config["version"];
}
