<?php namespace Adviser\Validators;

use Adviser\Messages\Message, Adviser\Messages\MessageBag;

class GitValidator extends AbstractValidator {

    /**
     * @inheritdoc
     */
    public function handle() {
        // 1) Check if $this->directory is a Git repository.
        // 2) If yes, check that remote.origin.url contains "github.com" or "bitbucket.org".
        return new MessageBag([new Message("foo", Message::ERROR)]);
    }
}
