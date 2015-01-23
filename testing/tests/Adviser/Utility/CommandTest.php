<?php namespace Adviser\Utility;

class CommandTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_runs_a_command() {
        $output = (new Command)->run(getcwd()."/testing/utility-command.sh");

        $this->assertTrue(is_array($output));

        $this->assertEquals($output["stdout"], "from stdout".PHP_EOL);
        $this->assertEquals($output["stderr"], "from stderr".PHP_EOL);
    }
}
