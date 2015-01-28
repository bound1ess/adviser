<?php namespace Adviser\Loaders;

interface LoaderInterface
{

    /**
     * Load from a configuration file.
     *
     * @return array
     */
    public function loadFromConfigurationFile();
}
