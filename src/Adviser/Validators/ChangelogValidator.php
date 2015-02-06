<?php namespace Adviser\Validators;

class ChangelogValidator extends AbstractValidator
{

    /**
     * @var array
     */
    protected $configuration = [
        "files" => [
            "Changelog.md", "changelog.md", // Most common.
            "HISTORY.md", "History.md", "history.md", // Sometimes.
            "CHANGES.md", "Changes.md", "changes.md", // Very rare.
        ],
    ];

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = $this->createMessageBag();

        $bag->throwIn($this->lookForChangelogFile());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function lookForChangelogFile()
    {
        $file = $this->utility("File");

        if ($file->exists($this->directory."/CHANGELOG.md")) {
            return $this->createNormalMessage("Your project has a CHANGELOG file.");
        }

        if ($file->anyExists($this->directory, $this->configuration["files"])) {
            return $this->createWarningMessage(
                "Looks like your project has a change log, but it's not CHANGELOG."
            );
        }

        return $this->createErrorMessage("Your project doesn't have a change log.");
    }
}
