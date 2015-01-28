<?php namespace Adviser\Utilities;

class CommandRunnerUtilityTest extends \Adviser\Testing\UtilityTestCase
{

    /** @test */ public function it_runs_a_command()
    {
        $output = (new CommandRunnerUtility())->run(getcwd()."/testing/utility-command.sh");

        $this->assertTrue(is_array($output));

        $this->assertEquals($output["stdout"], "from stdout".PHP_EOL);
        $this->assertEquals($output["stderr"], "from stderr".PHP_EOL);
    }

    /** @test */ public function it_throws_exception_if_something_goes_wrong()
    {
        $this->setExpectedException("RuntimeException");

        // Redefine for the current namespace.
        function proc_open()
        {
            return false;
        }

        (new CommandRunnerUtility())->run("something");
    }
}
