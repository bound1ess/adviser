<?php

// The project's root directory.
if ( ! defined("ADVISER_DIR")) {
    define("ADVISER_DIR", __DIR__."/..");
}

/**
 * Attempt to find the autoloader.
 *
 * @return void
 */
function findComposerAutoloader()
{
    if (file_exists($path = ADVISER_DIR."/vendor/autoload.php")) {
        return require $path;
    }

    require ADVISER_DIR."/../../autoload.php";
}

/**
 * Get Adviser's current version.
 *
 * @return string
 */
function getAdviserVersion()
{
    $configuration = (new Adviser\ConfigurationLoader())->load();

    return $configuration["version"];
}
