<?php namespace Adviser;

class FormatterLoader
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
     * Load formatters listed in the configuration file.
     *
     * @return array
     */
    public function loadFromConfigurationFile()
    {
        $formatters = [];

        foreach ($this->loader->load()["formatters"] as $formatter) {
            $instance = new $formatter();

            $formatters[$instance->getName()] = $instance;
        }

        return $formatters;
    }
}
