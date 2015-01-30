<?php namespace Adviser\Validators;

class ComposerValidator extends AbstractValidator
{

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = $this->createMessageBag();

        $message = $this->isManifestOK();

        if ( ! $message->isError()) {
            $bag->throwIn($this->lookForAutoloader("psr-4"));
            $bag->throwIn($this->checkIfPackageWasPublished());
            $bag->throwIn($this->checkIfSourceCodeIsStoredIn("src"));
        } else {
            $bag->throwIn($message);
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
            return $this->createNormalMessage(
                "Your manifest file (composer.json) is just fine."
            );
        }

        return $this->createErrorMessage("Something is wrong with your composer.json file.");
    }

    /**
     * @param string $name
     * @return Message
     */
    protected function lookForAutoloader($name)
    {
        if ( ! $this->utility("Composer")->hasAutoloader($this->directory, $name)) {
            return $this->createWarningMessage(
                "You should be using a {$name} autoloader for your project instead."
            );
        }

        return $this->createNormalMessage("Your project uses the {$name} autoloader.");
    }

    /**
     * @return Message
     */
    protected function checkIfPackageWasPublished()
    {
        $manifest = $this->utility("Composer")->readManifest($this->directory);

        if (is_null($manifest) || ! array_key_exists("name", $manifest)
            || ! $this->utility("Packagist")->packageExists($manifest["name"])) {
            return $this->createWarningMessage("Your project is not on Packagist.");
        }

        return $this->createNormalMessage(
            "Your project is available at packagist.org/packages/{$manifest['name']}."
        );
    }

    /**
     * @param string $directory
     * @return Message
     */
    protected function checkIfSourceCodeIsStoredIn($directory)
    {
        foreach ($this->utility("Composer")->getSourceDirectories($this->directory) as $path) {
            if (strpos($path, $directory) === 0) {
                return $this->createNormalMessage(
                    "Your project's source code is in the {$directory}/ directory."
                );
            }
        }

        return $this->createWarningMessage(
            "Your project's source code is not in the {$directory}/ directory."
        );
    }
}
