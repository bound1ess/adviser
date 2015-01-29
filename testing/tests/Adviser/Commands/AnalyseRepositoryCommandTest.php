<?php namespace Adviser\Commands;

class AnalyseRepositoryCommandTest extends \Adviser\Testing\CommandTestCase
{

    /**
     * @test
     */
    public function it_has_the_right_name_and_description()
    {
        $command = new AnalyseRepositoryCommand();

        $this->assertEquals($command->getName(), "analyse-repository");
        $this->assertEquals(
            $command->getDescription(),
            "Clones a GitHub repository and runs 'analyse' command on it"
        );
    }

    /**
     * @test
     */
    public function it_returns_something()
    {
        $this->assertNotEmpty($this->runCommand(
            new AnalyseRepositoryCommand(),
            ["name" => "repository/name"]
        ));
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_something_goes_wrong()
    {
        $this->setExpectedException("InvalidArgumentException");

        $this->runCommand(new AnalyseRepositoryCommand(), ["name" => "invalid"]);
    }
}
