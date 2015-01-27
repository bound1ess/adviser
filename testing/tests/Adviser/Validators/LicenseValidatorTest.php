<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

class LicenseValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /** @test */ public function it_does_its_job()
    {
        // Setup.
        $validator = new LicenseValidator(null);

        $file = Mockery::mock("Adviser\Utility\File");

        $file->shouldReceive("exists")
             ->times(1 + 1 + 1)
             ->andReturn(
                 true, // 1st scenario.
                 false, // 2nd scenario.
                 false // 3rd scenario.
             );

        $file->shouldReceive("anyExists")
             ->twice()
             ->andReturn(true, false);

        $validator->utility("File", $file);

        // Test.
        // 1st scenario: LICENSE file was found.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::NORMAL);

        // 2nd scenario: not LICENSE, but "License" or "license".
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::WARNING);

        // 3rd scenario: no license files were found.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::ERROR);
    }
}
