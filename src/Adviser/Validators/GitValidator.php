<?php namespace Adviser\Validators;

class GitValidator extends AbstractValidator {

    /**
     * @inheritdoc
     */
    public function handle() {
        // 1) Check if $this->directory is a Git repository.
        // 2) If yes, check that remote.origin.url contains "github.com" or "bitbucket.org".
    }
}
