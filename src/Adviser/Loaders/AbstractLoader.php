<?php namespace Adviser\Loaders;

abstract class AbstractLoader implements LoaderInterface
{

    /**
     * @inheritdoc
     */
    abstract public function loadFromConfigurationFile();
}
