<?php namespace Adviser\Commands;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;

class AnalyseCommandTest extends \PHPUnit_Framework_TestCase
{

    /** @test */ public function it_has_proper_name_and_description()
    {
        $command = new AnalyseCommand();

        $this->assertEquals($command->getName(), "analyse");
        $this->assertEquals(
            $command->getDescription(),
            "Suggests you possible improvements for your project"
        );
    }

    /** @test */ public function it_returns_correct_output_string()
    {
        $stream = fopen("php://memory", "r+");

        (new AnalyseCommand())->run(new ArrayInput([]), new StreamOutput($stream));

        rewind($stream);
        $this->assertNotEmpty(stream_get_contents($stream));
    }
}
