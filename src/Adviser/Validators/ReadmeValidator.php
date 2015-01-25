<?php namespace Adviser\Validators;

use Adviser\Messages\MessageBag, Adviser\Messages\Message;

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
        $bag = new MessageBag();

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
            return new Message("Your project has a README.md file.", Message::NORMAL);
        }

        if ($file->anyExists($this->directory, $this->files)) {
            return new Message(
                "Looks like your project has a readme file, but it's not README.md.",
                Message::WARNING
            );
        }

        return new Message("Your project does not have a readme file.", Message::ERROR);
    }
}
