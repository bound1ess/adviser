<?php namespace Adviser\Validators;

use Adviser\Messages\Message;
use Adviser\Messages\MessageBag;

class GitValidator extends AbstractValidator
{

    /**
     * @inheritdoc
     */
    public function handle()
    {
        // 1) Check if $this->directory is a Git repository.
        // 2) If yes, check that remote.origin.url contains "github.com" or "bitbucket.org".
        $bag = new MessageBag();

        $message = $this->checkIfGitRepository();
        $bag->throwIn($message);

        if ($message->getLevel() != Message::ERROR) {
            $bag->throwIn($this->checkIfRepositoryUrlIsCorrect());
        }

        return $bag;
    }

    /**
     * @return Message
     */
    protected function checkIfGitRepository()
    {
        if ($this->utility("Git")->isRepository($this->directory)) {
            return new Message("Your project is a Git repository.", Message::NORMAL);
        }

        return new Message("Your project is not a Git repository.", Message::ERROR);
    }

    /**
     * @return Message
     */
    protected function checkIfRepositoryUrlIsCorrect()
    {
        $config = $this->utility("Git")->getConfig();

        if (array_key_exists("remote.origin.url", $config)) {
            $url = $config["remote.origin.url"];

            if (strpos($url, "github.com") || strpos($url, "bitbucket.org")) {
                return new Message("Your remote repo's URL is fine.", Message::NORMAL);
            }

            return new Message(
                "Your remote repo's URL doesn't point to Github/Bitbucket.",
                Message::WARNING
            );
        }

        return new Message("Your remote repo's URL is not configured.", Message::ERROR);
    }
}
