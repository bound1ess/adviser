<?php namespace Adviser\Validators;

class CIValidator extends AbstractValidator
{

    /**
     * @var array
     */
    protected $configuration = [
        "allowedVersions" => ["hhvm", "5.6", "5.5", "5.4"],
    ];

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = $this->createMessageBag();

        $bag->throwIn($this->checkTravisConfigurationFile());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function checkTravisConfigurationFile()
    {
        if ( ! $this->utility("File")->exists($path = $this->directory."/.travis.yml")) {
            return $this->createErrorMessage(
                "Your project doesn't seem to be using Travis CI platform (travis-ci.org)."
            );
        }

        $config = $this->utility("YAMLParser")->parse($this->utility("File")->read($path));

        if ( ! array_key_exists("php", $config) or ! $this->checkVersions($config["php"])) {
            return $this->createWarningMessage(
                "Your .travis.yml file seems to be using the outdated versions of PHP."
            );
        }

        return $this->createNormalMessage(
            "Your project uses Travis and the settings are fine."
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
            if ( ! in_array($version, $this->configuration["allowedVersions"])) {
                return false;
            }
        }

        return true;
    }
}
