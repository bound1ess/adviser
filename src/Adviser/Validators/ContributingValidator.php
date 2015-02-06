<?php namespace Adviser\Validators;

class ContributingValidator extends AbstractValidator
{

    /**
     * @var array
     */
    protected $configuration = [
        "files" => [
            "Contributing.md", "contributing.md", // Common.
            "CONTRIB.md", "Contrib.md", "contrib.md", // Quite common as well.
            "CONTRIBUTION.md", "Contribution.md", "contribution.md", // I've seen this, too.
        ],
    ];

    /**
     * {@inheritdoc}
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

        if ($file->exists($this->directory."/CONTRIBUTING.md")) {
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
