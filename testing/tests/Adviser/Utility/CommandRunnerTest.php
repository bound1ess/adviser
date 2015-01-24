<?php namespace Adviser\Utility;

class CommandRunnerTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_runs_a_command() {
        $output = (new CommandRunner)->run(getcwd()."/testing/utility-command.sh");

        $this->assertTrue(is_array($output));

        $this->assertEquals($output["stdout"], "from stdout".PHP_EOL);
        $this->assertEquals($output["stderr"], "from stderr".PHP_EOL);
    }

    /** @test */ function it_throws_exception_if_something_goes_wrong() {
        $this->setExpectedException("RuntimeException");

        // Redefine for the current namespace.
        function proc_open() {
            return false;
        }

        (new CommandRunner)->run("something");
    }
}
