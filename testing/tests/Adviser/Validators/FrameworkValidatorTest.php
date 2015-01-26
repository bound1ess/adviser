<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

class FrameworkValidatorTest extends ValidatorTestCase
{

    /** @test */ public function it_does_its_job()
    {
        // Set everything up.
        $validator = new FrameworkValidator(null);

        // Mock Composer utility class.
        $composer = Mockery::mock("Adviser\Utility\Composer");

        $composer->shouldReceive("getDependencies")
                 ->twice()
                 ->with(null)
                 ->andReturn(["casual/package", "just/chilling"], ["laravel/framework"]);

        // Swap the "true" utility class with a mock.
        $validator->utility("Composer", $composer);

        // Test it!
        // 1st scenario: your project is framework agnostic.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::NORMAL);

        // 2nd scenario: your project depends on a framework.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::WARNING);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
