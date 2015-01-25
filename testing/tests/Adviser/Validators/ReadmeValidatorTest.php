<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

// Mock for testing purposes.
function file_exists()
{
    static $returnValue = [
        true, // 1st scenario.
        false, false, false, false, true, // 2nd scenario.
        false, false, false, false, false, // 3rd scenario.
    ];

    return array_shift($returnValue);
}

class ReadmeValidatorTest extends ValidatorTestCase
{

    /** @test */ public function it_does_its_job()
    {
        // Setup.
        $validator = new ReadmeValidator(null);

        // Testing.
        // 1st scenario: there is a README.md file, everything is cool.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::NORMAL);

        // 2nd scenario: there is a readme.md/Readme.md file.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::WARNING);

        // 3rd scenario: there is nothing like that.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::ERROR);
    }
}
