<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

class TestValidatorTest extends ValidatorTestCase
{

    /** @test */ public function it_does_its_job()
    {
        // Setup.
        $validator = new TestValidator(null);

        $file = Mockery::mock("Adviser\Utility\File");

        $composer = Mockery::mock("Adviser\Utility\Composer");
    }
}
