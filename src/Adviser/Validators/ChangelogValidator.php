<?php namespace Adviser\Validators;

use Adviser\Messages\Message, Adviser\Messages\MessageBag;

class ChangelogValidator extends AbstractValidator
{

    /**
     * @var array
     */
    protected $files = [
        "Changelog", "changelog", // Most common.
        "HISTORY", "History", "history", // Sometimes.
        "CHANGES", "Changes", "changes", // Very rare.
    ];

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = new MessageBag();

        $bag->throwIn($this->lookForChangelogFile());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function lookForChangelogFile()
    {
        $file = $this->utility("File");

        if ($file->exists($this->directory."/CHANGELOG")) {
            return new Message("Your project has a CHANGELOG file.", Message::NORMAL);
        }

        if ($file->anyExists($this->directory, $this->files)) {
            return new Message(
                "Looks like your project has a change log, but it's not CHANGELOG.",
                Message::WARNING
            );
        }

        return new Message("Your project doesn't have a change log.", Message::ERROR);
    }
}
