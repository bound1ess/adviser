<?php

return [
    // Adviser's current version.
    "version" => "0.1.1",

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
