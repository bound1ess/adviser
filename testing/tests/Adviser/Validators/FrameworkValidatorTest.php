<?php namespace Adviser\Validators;

class FrameworkValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /**
     * @test
     */
    public function it_does_its_job()
    {
        // Set everything up.
        $validator = new FrameworkValidator(null);

        // Mock Composer utility class.
        $composer = $this->mockUtility("Composer");

        $composer->shouldReceive("getDependencies")
                 ->twice()
                 ->with(null)
                 ->andReturn(["casual/package", "just/chilling"], ["laravel/framework"]);

        // Swap the "true" utility class with a mock.
        $validator->utility("Composer", $composer);

        // Test it!
        // 1st scenario: your project is framework agnostic.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isNormal());

        // 2nd scenario: your project depends on a framework.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isWarning());
    }
}
