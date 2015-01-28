<?php namespace Adviser\Validators;

class ReadmeValidator extends AbstractValidator
{

    /**
     * @var array
     */
    protected $files = ["Readme", "readme", "Readme.md", "readme.md"];

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = $this->createMessageBag();

        $bag->throwIn($this->lookForReadmeFile());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function lookForReadmeFile()
    {
        $file = $this->utility("File");

        if ($file->exists($this->directory."/README.md")) {
            return $this->createNormalMessage("Your project has a README.md file.");
        }

        if ($file->anyExists($this->directory, $this->files)) {
            return $this->createWarningMessage(
                "Looks like your project has a readme file, but it's not README.md."
            );
        }

        return $this->createErrorMessage("Your project does not have a readme file.");
    }
}
