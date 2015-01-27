<?php namespace Adviser\Validators;

class LicenseValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /**
     * @test
     */
    public function it_does_its_job()
    {
        // Setup.
        $validator = new LicenseValidator(null);

        $file = $this->mockUtility("File");

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
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isNormal());

        // 2nd scenario: not LICENSE, but "License" or "license".
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isWarning());

        // 3rd scenario: no license files were found.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isError());
    }
}
