<?php namespace Adviser\Utility;

class Git {

    /**
     * @var Command
     */
    protected $runner;

    /**
     * @param Command $runner
     * @return Git
     */
    public function __construct(Command $runner) {
        $this->runner = $runner;
    }

    /**
     * Return the tags for this repository.
     *
     * @return array
     */
    public function getTags() {
        return ["0.0.0"];
    }
}
