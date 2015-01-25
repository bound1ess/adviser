<?php namespace Adviser\Validators;

use Adviser\Messages\MessageBag, Adviser\Messages\Message;

class ReadmeValidator extends AbstractValidator
{

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = new MessageBag();

        $bag->throwIn($this->lookForReadmeFile());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function lookForReadmeFile()
    {
        if ($this->utility("File")->exists($this->directory."/README.md")) {
            return new Message("Your project has a README.md file.", Message::NORMAL);
        }

        if ($this->anyExists(["Readme", "readme", "Readme.md", "readme.md"])) {
            return new Message(
                "Looks like your project has a readme file, but it's not README.md.",
                Message::WARNING
            );
        }

        return new Message("Your project does not have a readme file.", Message::ERROR);
    }

    /**
     * @param array $files
     * @return boolean
     */
    protected function anyExists($files)
    {
        foreach ($files as $file) {
            if ($this->utility("File")->exists($this->directory."/".$file)) {
                return true;
            }
        }

        return false;
    }
}
