<?php namespace Adviser\Utility;

class CommandTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_runs_a_command() {
        $output = (new Command)->run(getcwd()."/testing/utility_command.sh");

        $this->assertInstanceOf("Adviser\Utility\CommandOutput", $output);
    }
}
