<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

class CIValidatorTest extends ValidatorTestCase
{

    /** @test */ public function it_does_its_job()
    {
        // Setup.
        $validator = new CIValidator(null);

        $file = Mockery::mock("Adviser\Utility\File");
        $YAMLParser = Mockery::mock("Adviser\Utility\YAMLParser");

        $validator->utility("File", $file);
        $validator->utility("YAMLParser", $YAMLParser);

        // Test.
    }
}
