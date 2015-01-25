<?php namespace Adviser\Utility;

class Composer
{

    /**
     * @var CommandRunner
     */
    protected $runner;

    /**
     * @param CommandRunner|null $runner
     * @return Composer
     */
    public function __construct(CommandRunner $runner = null)
    {
        $this->runner = $runner ?: new CommandRunner;
    }

    /**
     * Check if there is a composer.json file in $directory.
     *
     * @param string $directory
     * @return boolean
     */
    public function manifestExists($directory)
    {
        return file_exists($directory."/composer.json");
    }

    /**
     * Check if there is a composer.json file in $directory and it is valid.
     * We will use the "validate" command on Composer CLI to check it.
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
     * Read the manifest file.
     *
     * @param string $directory
     * @return null|array
     */
    protected function readManifest($directory)
    {
        if ( ! $this->manifestExists($directory)) {
            return null;
        }

        return json_decode(file_get_contents($directory."/composer.json"), true);
    }

    /**
     * Return either "./composer.phar" or "composer".
     *
     * @param string $directory
     * @return string
     */
    protected function getComposerExecutablePath($directory)
    {
        return file_exists($path = $directory."/composer.phar") ? $path : "composer";
    }
}
