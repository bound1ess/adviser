<?php namespace Adviser\Validators;

use Adviser\Messages\Message, Adviser\Messages\MessageBag;

class ComposerValidator extends AbstractValidator
{

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = new MessageBag();

        $bag->throwIn($message = $this->isManifestValid());

        if ($message->getLevel() != Message::ERROR) {
            $bag->throwIn($this->lookForAutoloader("psr-4"));
            $bag->throwIn($this->checkIfPackageWasPublished());
            $bag->throwIn($this->checkIfSourceCodeIsStoredIn("src"));
        }

        return $bag;
    }

    /**
     * @return Message
     */
    protected function isManifestValid()
    {

    }

    /**
     * @param string $name
     * @return Message
     */
    protected function lookForAutoloader($name)
    {

    }

    /**
     * @return Message
     */
    protected function checkIfPackageWasPublished()
    {

    }

    /**
     * @param string $directory
     * @return Message
     */
    protected function checkIfSourceCodeIsStoredIn($directory)
    {

    }
}
