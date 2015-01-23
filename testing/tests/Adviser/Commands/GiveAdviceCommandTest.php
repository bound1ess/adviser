<?php namespace Adviser\Commands;

class GiveAdviceCommandTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_has_proper_name_and_description() {
        $command = new GiveAdviceCommand;

        $this->assertEquals($command->getName(), "give-advice");
        $this->assertEquals($command->getDescription(), "Suggests you possible improvements");
    }
}
