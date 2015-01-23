<?php namespace Adviser\Utility;

class CommandOutput {

    /**
     * @var mixed
     */
    protected $stdout;

    /**
     * @var mixed
     */
    protected $stderr;

    /**
     * @param mixed $stdout
     * @param mixed $stderr
     * @return CommandOutput
     */
    public function __construct($stdout, $stderr) {
        $this->stdout = $stdout;
        $this->stderr = $stderr;
    }

    /**
     * @return string
     */
    public function getStdout() {
        $content = stream_get_contents($this->stdout);
        fclose($this->stdout);

        return $content;
    }

    /**
     * @return string
     */
    public function getStderr() {
        $content = stream_get_contents($this->stderr);
        fclose($this->stderr);

        return $content;
    }
}
