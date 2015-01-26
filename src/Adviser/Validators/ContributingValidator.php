<?php namespace Adviser\Validators;

use Adviser\Messages\Message, Adviser\Messages\MessageBag;

class ContributingValidator extends AbstractValidator
{

    /**
     * @var array
     */
    protected $files = [
        "Contributing", "contributing", // Common.
        "CONTRIB", "Contrib", "contrib", // Quite common as well.
        "CONTRIBUTION", "Contribution", "contribution", // I've seen this, too.
    ];

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = new MessageBag();

        $bag->throwIn($this->lookForContributingInstructions());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function lookForContributingInstructions()
    {
        if ($this->utility("File")->exists($this->directory."/CONTRIBUTING")) {
            return new Message("Your project has a CONTRIBUTING file.", Message::NORMAL);
        }

        if ($this->utility("File")->anyExists($this->directory, $this->files)) {
            return new Message(
                "Your project has contributing instructions, but not in a CONTRIBUTING file.",
                Message::WARNING
            );
        }

        return new Message(
            "There are no contributing instructions for your project.",
            Message::ERROR
        );
    }
}
