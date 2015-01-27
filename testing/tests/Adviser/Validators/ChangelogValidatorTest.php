<?php namespace Adviser\Validators;

class ChangelogValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /**
     * @test
     */
    public function it_does_its_job()
    {
        // Setup.
        $validator = new ChangelogValidator(null);

        $file = $this->mockUtility("File");

        $file->shouldReceive("exists")
             ->times(3)
             ->andReturn(true, false, false);

        $file->shouldReceive("anyExists")
             ->twice()
             ->andReturn(true, false);

        $validator->utility("File", $file);

        // Test.
        // 1st scenario: there is a CHANGELOG file.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isNormal());

        // 2nd scenario: it's not "CHANGELOG", but something similar.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isWarning());

        // 3rd scenario: nothing could be found.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isError());
    }
}
