<?php namespace Adviser\Utility;

class Git {

    /**
     * @var CommandRunner
     */
    protected $runner;

    /**
     * @param CommandRunner $runner
     * @return Git
     */
    public function __construct(CommandRunner $runner) {
        $this->runner = $runner;
    }

    /**
     * Return the tags for this repository.
     *
     * @return array
     */
    public function getTags() {
        return array_filter(explode(PHP_EOL, $this->runner->run("git tag")["stdout"]));
    }
}
