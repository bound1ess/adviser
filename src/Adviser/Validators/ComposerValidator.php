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

        $bag->throwIn($message = $this->isManifestOK());

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
    protected function isManifestOK()
    {
        $composer = $this->utility("Composer");

        if ( ! is_null($composer->readManifest($this->directory))) {
            return new Message(
                "Your manifest file (composer.json) is just fine.",
                Message::NORMAL
            );
        }

        return new Message("Something is wrong with your composer.json file.", Message::ERROR);
    }

    /**
     * @param string $name
     * @return Message
     */
    protected function lookForAutoloader($name)
    {
        if ( ! $this->utility("Composer")->hasAutoloader($this->directory, $name)) {
            return new Message(
                "You should be using the {$name} autoloader for your project instead.",
                Message::WARNING
            );
        }

        return new Message("Your project uses the {$name} autoloader.", Message::NORMAL);
    }

    /**
     * @return Message
     */
    protected function checkIfPackageWasPublished()
    {
        $manifest = $this->utility("Composer")->readManifest($this->directory);

        if ( ! $this->utility("Packagist")->packageExists($manifest["name"])) {
            return new Message("Your project is not on Packagist.", Message::WARNING);
        }

        return new Message(
            "Your project is available at packagist.org/packages/{$manifest['name']}",
            Message::NORMAL
        );
    }

    /**
     * @param string $directory
     * @return Message
     */
    protected function checkIfSourceCodeIsStoredIn($directory)
    {
        foreach ($this->utility("Composer")->getSourceDirectories($directory) as $path) {
            if (strpos($path, "src") === 0) {
                return new Message(
                    "Your project's code is in the src/ directory, so it's easy to find.",
                    Message::NORMAL
                );
            }
        }

        return new Message(
            "Your project's source code is not in the src/ directory.",
            Message::WARNING
        );
    }
}
