<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

class TestValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /** @test */ public function it_does_its_job()
    {
        // Setup.
        $validator = new TestValidator(null);

        $file = Mockery::mock("Adviser\Utility\File");

        $file->shouldReceive("exists")
             ->times(3)
             ->andReturn(
                 false, false, // 2nd scenario.
                 true // 3rd scenario.
             );

        $composer = Mockery::mock("Adviser\Utility\Composer");

        $composer->shouldReceive("getDependencies")
                 ->times(3)
                 ->with(null, true)
                 ->andReturn(
                     ["weird/package", "behat/behat"],
                     ["phpspec/phpspec"],
                     ["phpunit/phpunit"]
                 );

        $validator->utility("File", $file);
        $validator->utility("Composer", $composer);

        // Test.
        // 1st scenario: no testing frameworks were found in your composer.json.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::ERROR);

        // 2nd scenario: a testing framework is present, but no configuration file was found.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::WARNING);

        // 3rd scenario: a testing framework is present, and it is configured.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::NORMAL);
    }
}
