<?php

// Require the main bootstrap file.
require __DIR__."/../src/bootstrap.php";

// Easy way to detect test environment.
if ( ! defined("ADVISER_UNDER_TEST")) {
    define("ADVISER_UNDER_TEST", true);
}

// This value is used in some unit tests.
// If needed, change it here.
// $_SERVER["HOME"] = "/tmp";

findComposerAutoloader();
