<?php namespace Adviser\Validators;

use Adviser\Messages\Message, Adviser\Messages\MessageBag;

class SemVerValidator extends AbstractValidator
{

    /**
     * @inheritdoc
     */
    public function handle()
    {
        // 1) Check if this project is a Git repository.
        // 2) Check if all tags for this repository are in "MAJOR.MINOR.PATCH" format.
        $bag = new MessageBag();

        $message = $this->checkIfGitRepository();

        if ( ! is_null($message)) {
            $bag->throwIn($message);
        } else {
            $bag->throwIn($this->checkTags());
        }

        return $bag;
    }

    /**
     * @return Message|null
     */
    protected function checkIfGitRepository()
    {
        if ( ! $this->utility("Git")->isRepository($this->directory)) {
            return new Message("Your project is not a Git repository.", Message::ERROR);
        }
    }

    /**
     * @return Message
     */
    protected function checkTags()
    {
        foreach ($this->utility("Git")->getTags() as $tag) {
            // Very primitive way.
            if (count(explode(".", $tag)) != 3) {
                return new Message(
                    "Your tags are not SemVer. See semver.org for more information.",
                    Message::WARNING
                );
            }
        }

        return new Message("You project tags are fine.", Message::NORMAL);
    }
}
