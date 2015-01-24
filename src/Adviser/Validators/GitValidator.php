<?php namespace Adviser\Validators;

use Adviser\Messages\Message, Adviser\Messages\MessageBag;

class GitValidator extends AbstractValidator {

    /**
     * @inheritdoc
     */
    public function handle() {
        // 1) Check if $this->directory is a Git repository.
        // 2) If yes, check that remote.origin.url contains "github.com" or "bitbucket.org".
        $bag = new MessageBag;

        if ($this->utility("Git")->isRepository($this->directory)) {
            $bag->throwIn(
                new Message("Your project is a Git repository.", Message::NORMAL)
            );
        } else {
            $bag->throwIn(
                new Message("Your project is not a Git repository.", Message::ERROR)
            );
        }

        return $bag;
    }
}
