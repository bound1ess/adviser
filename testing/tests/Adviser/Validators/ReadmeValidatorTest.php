<?php namespace Adviser\Validators;

class ReadmeValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /**
     * @test
     */
    public function it_does_its_job()
    {
        // Setup.
        $validator = new ReadmeValidator(null);

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

        // Testing.
        // 1st scenario: there is a README.md file, everything is cool.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isNormal());

        // 2nd scenario: there is a readme.md/Readme.md file.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isWarning());

        // 3rd scenario: there is nothing like that.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isError());
    }
}
