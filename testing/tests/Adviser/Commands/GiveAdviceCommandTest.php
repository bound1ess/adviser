<?php namespace Adviser\Commands;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\StreamOutput;

class GiveAdviceCommandTest extends \PHPUnit_Framework_TestCase
{

    /** @test */ public function it_has_proper_name_and_description()
    {
        $command = new GiveAdviceCommand();

        $this->assertEquals($command->getName(), "give-advice");
        $this->assertEquals($command->getDescription(), "Suggests you possible improvements");
    }

    /** @test */ public function it_returns_correct_output_string()
    {
        $stream = fopen("php://memory", "r+");

        (new GiveAdviceCommand())->run(new ArrayInput([]), new StreamOutput($stream));

        rewind($stream);
        $this->assertEquals(stream_get_contents($stream), "Hello, world!".PHP_EOL);
    }
}
