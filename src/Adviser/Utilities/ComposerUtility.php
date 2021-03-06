<?php namespace Adviser\Utilities;

class ComposerUtility extends AbstractUtility
{

    /**
     * @var CommandRunnerUtility
     */
    protected $runner;

    /**
     * @param CommandRunnerUtility|null $runner
     * @return Composer
     */
    public function __construct(CommandRunnerUtility $runner = null)
    {
        $this->runner = $runner ?: new CommandRunnerUtility();
    }

    /**
     * Check if there is a composer.json file in given directory.
     *
     * @param string $directory
     * @return boolean
     */
    public function manifestExists($directory)
    {
        return file_exists($directory."/composer.json");
    }

    /**
     * Check if there is a composer.json file in given directory and it is valid.
     * We will use the "validate" command provided by the Composer CLI to find it out.
     *
     * @param string $directory
     * @return boolean
     */
    public function isManifestValid($directory)
    {
        $output = $this->runner->run($this->getComposerExecutablePath($directory)." validate");

        return $output["stdout"] == "./composer.json is valid".PHP_EOL;
    }

    /**
     * Check if an autoloader of given type was configured in the manifest file.
     * Possible types: "psr-0", "psr-4", "classmap", "files".
     *
     * @param string $directory
     * @param string $type
     * @return boolean
     */
    public function hasAutoloader($directory, $type)
    {
        if (is_null($manifest = $this->readManifest($directory))) {
            return false;
        }

        return array_key_exists("autoload", $manifest)
            && array_key_exists($type, $manifest["autoload"]);
    }

    /**
     * Read the manifest and return all source directories listed there.
     *
     * @param string $directory
     * @return array
     */
    public function getSourceDirectories($directory)
    {
        if (is_null($manifest = $this->readManifest($directory))
            or ! array_key_exists("autoload", $manifest)) {
            return [];
        }

        $directories = [];

        foreach ($manifest["autoload"] as $map) {
            $directories = array_merge($directories, array_values($map));
        }

        return $directories;
    }

    /**
     * Get the dependencies list.
     *
     * @param string $directory
     * @param boolean $development
     * @return array
     */
    public function getDependencies($directory, $development = false)
    {
        if (is_null($manifest = $this->readManifest($directory))) {
            return [];
        }

        $get = function($key) use($manifest)
        {
            return array_key_exists($key, $manifest) ? array_keys($manifest[$key]) : [];
        };

        $production = $get("require");

        return $development ? array_merge($get("require-dev"), $production) : $production;
    }

    /**
     * Read the manifest file.
     *
     * @param string $directory
     * @return null|array
     */
    public function readManifest($directory)
    {
        if ( ! $this->manifestExists($directory)) {
            return null;
        }

        return json_decode(file_get_contents($directory."/composer.json"), true);
    }

    /**
     * This method returns either "./composer.phar" or just "composer".
     *
     * @param string $directory
     * @return string
     */
    protected function getComposerExecutablePath($directory)
    {
        return file_exists($directory."/composer.phar") ? "./composer.phar" : "composer";
    }
}
