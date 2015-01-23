<?php namespace Adviser\Utility;

use RuntimeException;

class Command {

    /**
     * Run a command.
     *
     * @throws RuntimeException
     * @param string $command
     * @return CommandOutput
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

        $output = new CommandOutput($pipes[2], $pipes[1]);
        proc_close($process);

        return $output;
    }
}
