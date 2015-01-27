<?php namespace Adviser\Validators;

class ContributingValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /**
     * @test
     */
    public function it_does_its_job()
    {
        // Setup.
        $validator = new ContributingValidator(null);

        $file = $this->mockUtility("File");

        $file->shouldReceive("exists")
             ->times(3)
             ->andReturn(true, false, false);

        $file->shouldReceive("anyExists")
             ->twice()
             ->andReturn(true, false);

        $validator->utility("File", $file);

        // Test.
        // 1st scenario: there is a CONTRIBUTING file.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isNormal());

        // 2nd scenario: there is such a file, but it's not exactly CONTRIBUTING.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isWarning());

        // 3rd scenario: there are no contributing instructions for your project.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isError());
    }
}
