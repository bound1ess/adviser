<?php namespace Adviser\Validators;

use Adviser\Messages\Message, Adviser\Messages\MessageBag;

class CIValidator extends AbstractValidator
{

    /**
     * @var array
     */
    protected $allowedVersions = ["hhvm", "5.6", "5.5", "5.4"];

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = new MessageBag();

        $bag->throwIn($this->checkTravisConfigurationFile());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function checkTravisConfigurationFile()
    {
        if ( ! $this->utility("File")->exists($path = $this->directory."/.travis.yml")) {
            return new Message(
                "Your project doesn't seem to be using Travis CI platform (travis-ci.org).",
                Message::ERROR
            );
        }

        $config = $this->utility("YAMLParser")->parse($this->utility("File")->read($path));

        if ( ! array_key_exists("php", $config) or ! $this->checkVersions($config["php"])) {
            return new Message(
                "Your .travis.yml file seems to be using the outdated versions of PHP.",
                Message::WARNING
            );
        }

        return new Message(
            "Your project uses Travis and the settings are fine.",
            Message::NORMAL
        );
    }

    /**
     * Look for outdated versions of PHP.
     *
     * @param array $versions
     * @return boolean
     */
    protected function checkVersions(array $versions)
    {
        foreach ($versions as $version) {
            if ( ! in_array($version, $this->allowedVersions)) {
                return false;
            }
        }

        return true;
    }
}
