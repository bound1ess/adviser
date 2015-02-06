<?php namespace Adviser\Validators;

class GitValidator extends AbstractValidator
{

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $bag = $this->createMessageBag();

        $message = $this->checkIfGitRepository();

        $bag->throwIn($message);

        if ( ! $message->isError()) {
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
            return $this->createNormalMessage("Your project is a Git repository.");
        }

        return $this->createErrorMessage("Your project is not a Git repository.");
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
                return $this->createNormalMessage("Your remote repo's URL is fine.");
            }

            return $this->createWarningMessage(
                "Your remote repo's URL doesn't point to Github/Bitbucket."
            );
        }

        return $this->createErrorMessage("Your remote repo's URL is not configured.");
    }
}
