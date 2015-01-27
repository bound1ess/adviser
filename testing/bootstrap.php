<?php

require __DIR__."/../src/bootstrap.php";

if ( ! defined("ADVISER_UNDER_TEST")) {
    define("ADVISER_UNDER_TEST", true);
}

findComposerAutoloader();
