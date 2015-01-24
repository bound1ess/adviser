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

            $config = $this->utility("Git")->getConfig();

            if (array_key_exists("remote.origin.url", $config)) {
                $url = $config["remote.origin.url"];

                $bag->throwIn(
                    new Message("Your remote repo's URL is configured.", Message::NORMAL)
                );

                if (strpos($url, "github.com") || strpos($url, "bitbucket.org")) {
                    $bag->throwIn(
                        new Message("Your remote repo's URL is fine.", Message::NORMAL)
                    );
                } else {
                    $bag->throwIn(
                        new Message(
                            "Your remote repo's URL doesn't point to Github/Bitbucket.",
                            Message::WARNING
                        )
                    );
                }
            } else {
                $bag->throwIn(
                    new Message("Your remote repo's URL is not configured.", Message::ERROR)
                );
            }
        } else {
            $bag->throwIn(
                new Message("Your project is not a Git repository.", Message::ERROR)
            );
        }

        return $bag;
    }
}
