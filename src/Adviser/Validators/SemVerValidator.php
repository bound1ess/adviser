<?php namespace Adviser\Validators;

class SemVerValidator extends AbstractValidator
{

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = $this->createMessageBag();

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
            return $this->createErrorMessage("Your project is not a Git repository.");
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
                return $this->createWarningMessage(
                    "Your tags are not SemVer. See semver.org for more information."
                );
            }
        }

        return $this->createNormalMessage("You project tags are fine.");
    }
}
