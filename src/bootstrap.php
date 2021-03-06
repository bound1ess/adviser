<?php

// The project's root directory.
if ( ! defined("ADVISER_DIR")) {
    define("ADVISER_DIR", __DIR__."/..");
}

if ( ! function_exists("findComposerAutoloader")) {
    /**
     * Attempt to find the autoloader.
     *
     * @return void
     */
    function findComposerAutoloader()
    {
        if (file_exists($path = ADVISER_DIR."/vendor/autoload.php")) {
            require $path;
        } else {
            require ADVISER_DIR."/../../autoload.php";
        }
    }
}

if ( ! function_exists("getAdviserVersion")) {
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
}
