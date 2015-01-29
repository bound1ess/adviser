<?php namespace Adviser\Validators;

class ContributingValidator extends AbstractValidator
{

    /**
     * @var array
     */
    protected $configuration = [
        "files" => [
            "Contributing", "contributing", // Common.
            "CONTRIB", "Contrib", "contrib", // Quite common as well.
            "CONTRIBUTION", "Contribution", "contribution", // I've seen this, too.
        ],
    ];

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = $this->createMessageBag();

        $bag->throwIn($this->lookForContributingInstructions());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function lookForContributingInstructions()
    {
        $file = $this->utility("File");

        if ($file->exists($this->directory."/CONTRIBUTING")) {
            return $this->createNormalMessage("Your project has a CONTRIBUTING file.");
        }

        if ($file->anyExists($this->directory, $this->configuration["files"])) {
            return $this->createWarningMessage(
                "Your project has contributing instructions, but not in a CONTRIBUTING file."
            );
        }

        return $this->createErrorMessage(
            "There are no contributing instructions for your project."
        );
    }
}
