<?php namespace Adviser\Utility;

class Git
{

    /**
     * @var CommandRunner
     */
    protected $runner;

    /**
     * @param CommandRunner|null $runner
     * @return Git
     */
    public function __construct(CommandRunner $runner = null)
    {
        $this->runner = $runner ?: new CommandRunner;
    }

    /**
     * Return the tags for this repository.
     *
     * @return array
     */
    public function getTags()
    {
        return $this->splitIntoLines($this->runner->run("git tag")["stdout"]);
    }

    /**
     * Check if given directory is a Git repository.
     *
     * @param string $directory
     * @return boolean
     */
    public function isRepository($directory)
    {
        return file_exists($directory."/.git/");
    }

    /**
     * Return "git config -l" output, but converted to an array of lines.
     *
     * @return array
     */
    public function getConfig()
    {
        $lines = $this->splitIntoLines($this->runner->run("git config -l")["stdout"]);
        $config = [];

        foreach ($lines as $line) {
            list($key, $value) = explode("=", $line);

            $config[$key] = $value;
        }

        return $config;
    }

    /**
     * Split input string into lines.
     *
     * @param string $input
     * @return array
     */
    protected function splitIntoLines($input)
    {
        return array_filter(explode(PHP_EOL, $input));
    }
}
