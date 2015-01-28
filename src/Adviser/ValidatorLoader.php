<?php namespace Adviser;

class ValidatorLoader
{

    /**
     * @var ConfigurationLoader
     */
    protected $loader;

    /**
     * @param ConfigurationLoader|null $loader
     * @return ValidatorLoader
     */
    public function __construct(ConfigurationLoader $loader = null)
    {
        $this->loader = $loader ?: new ConfigurationLoader();
    }

    /**
     * Load validators listed in the configuration file.
     *
     * @return array
     */
    public function loadFromConfigurationFile()
    {
        $config = $this->loader->load();
        $validators = [];

        foreach ($config["validators"] as $validator) {
            $validators[] = new $validator(getcwd());
        }

        return $validators;
    }
}
