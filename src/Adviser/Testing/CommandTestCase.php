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
     * @param ArrayInput|null $input
     * @return string
     */
    protected function runCommand(Command $command, ArrayInput $input = null)
    {
        $stream = fopen("php://memory", "r+");
        $input = $input ?: new ArrayInput([]);

        $command->run($input, new StreamOutput($stream));
        rewind($stream);

        return stream_get_contents($stream);
    }
}
