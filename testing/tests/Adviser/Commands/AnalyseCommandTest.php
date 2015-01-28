<?php namespace Adviser\Commands;

class AnalyseCommandTest extends \Adviser\Testing\CommandTestCase
{

    /**
     * @test
     */
    public function it_has_the_right_name_and_description()
    {
        $command = new AnalyseCommand();

        $this->assertEquals($command->getName(), "analyse");

        $this->assertEquals(
            $command->getDescription(),
            "Suggests you possible improvements for your project"
        );
    }

    /**
     * @test
     */
    public function it_returns_something()
    {
        $this->assertNotEmpty($this->runCommand(new AnalyseCommand()));
    }
}
