<?php namespace Adviser\Utility;

class Git {

    /**
     * @var CommandRunner|null
     */
    protected $runner;

    /**
     * @param CommandRunner|null $runner
     * @return Git
     */
    public function __construct(CommandRunner $runner = null) {
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
