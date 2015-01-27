<?php namespace Adviser\Validators;

class SemVerValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /**
     * @test
     */
    public function it_does_its_job()
    {
        // Setup.
        $validator = new SemVerValidator(null);

        $git = $this->mockUtility("Git");

        $git->shouldReceive("isRepository")
            ->times(3)
            ->with(null)
            ->andReturn(false, true, true);

        $git->shouldReceive("getTags")
            ->twice()
            ->andReturn(["0.0.0", "1.2"], ["1.2.3", "12.0.14"]);

        $validator->utility("Git", $git);

        // Actual testing.
        // 1st scenario: not a Git repository.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isError());

        // 2nd scenario: Git repository, but tags are not SemVer.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isWarning());

        // 3rd scenario: Git repository, tags are fine, too.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isNormal());
    }
}
