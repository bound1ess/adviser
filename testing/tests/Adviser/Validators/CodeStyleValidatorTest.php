<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

class CodeStyleValidatorTest extends ValidatorTestCase
{

    /** @test */ public function it_does_its_job()
    {
        // Setup.
        $validator = new CodeStyleValidator(null);

        $commandRunner = Mockery::mock("Adviser\Utility\CommandRunner");
        $commandRunner->shouldReceive("run")
                      ->twice()
                      ->andReturn(
                          ["stdout" => "I..F..E"], // 2nd scenario.
                          ["stdout" => "......."] // 3rd scenario.
                      );

        $file = Mockery::mock("Adivser\Utility\File");
        $file->shouldReceive("exists")
             ->times(3 + 2 + 1)
             ->andReturn(
                 false, false, false, // 1st scenario.
                 false, true, // 2nd scenario.
                 true // 3rd scenario.
             );

        $validator->utility("CommandRunner", $commandRunner);
        $validator->utility("File", $file);

        // Test.
        // 1st scenario: couldn't find the php-cs-fixer executable file.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::ERROR);

        // 2nd scenario: PSR-2 coding standard violations.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::WARNING);

        // 3rd scenario: everything is fine.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::NORMAL);
    }
}
