<?php namespace Adviser\Utility;

use RuntimeException;

class Command {

    /**
     * Run a command.
     *
     * @throws RuntimeException
     * @param string $command
     * @return array
     */
    public function run($command) {
        $pipes = [];
        $specification = [
            ["pipe", "r"],
            ["pipe", "w"],
            ["pipe", "w"],
        ];

        $process = proc_open($command, $specification, $pipes, getcwd(), null);

        if ( ! is_resource($process)) {
            throw new RuntimeException;
        }

        $output = [
            "stdout" => $this->readAndClose($pipes[1]),
            "stderr" => $this->readAndClose($pipes[2]),
        ];

        proc_close($process);

        return $output;
    }

    /**
     * Read stream contents and then close it.
     *
     * @param mixed $pipe
     * @return string
     */
    protected function readAndClose($pipe) {
        $content = stream_get_contents($pipe);
        fclose($pipe);

        return $content;
    }
}
