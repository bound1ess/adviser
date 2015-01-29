<?php namespace Adviser\Testing;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * @codeCoverageIgnore
 */
class CommandTestCase extends TestCase
{

    /**
     * Run given command and return its output.
     *
     * @param Command $command
     * @param array $input
     * @return string
     */
    protected function runCommand(Command $command, array $input = [])
    {
        $stream = fopen("php://memory", "r+");
        $input = new ArrayInput($input);

        $command->run($input, new StreamOutput($stream));
        rewind($stream);

        return stream_get_contents($stream);
    }
}
