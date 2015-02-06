<?php namespace Adviser\Validators;

class LicenseValidator extends AbstractValidator
{

    /**
     * @var array
     */
    protected $configuration = [
        "files" => [
            "License", "license",
            "LICENSE.md", "License.md", "license.md",
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $bag = $this->createMessageBag();

        $bag->throwIn($this->lookForLicenseFile());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function lookForLicenseFile()
    {
        $file = $this->utility("File");

        if ($file->exists($this->directory."/LICENSE")) {
            return $this->createNormalMessage("Your project has a LICENSE file.");
        }

        if ($file->anyExists($this->directory, $this->configuration["files"])) {
            return $this->createWarningMessage(
                "Looks like your project has a license file, but it's not LICENSE."
            );
        }

        return $this->createErrorMessage("Your project doesn't have a license file.");
    }
}
