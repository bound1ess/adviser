<?php

// All values that I don't want to be hardcoded are stored here.

return [
    // Adviser's current version.
    "version" => "0.1.0",

    "validators" => [
        "Adviser\Validators\GitValidator",
        "Adviser\Validators\ComposerValidator",
        "Adviser\Validators\FrameworkValidator",
        "Adviser\Validators\CodeStyleValidator",
        "Adviser\Validators\TestValidator",
        "Adviser\Validators\CIValidator",
        "Adviser\Validators\SemVerValidator",
        "Adviser\Validators\ChangelogValidator",
        "Adviser\Validators\ReadmeValidator",
        "Adviser\Validators\ContributingValidator",
        "Adviser\Validators\LicenseValidator",
    ],
];
