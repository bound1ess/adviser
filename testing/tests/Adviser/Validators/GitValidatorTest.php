<?php namespace Adviser\Validators;

class GitValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /**
     * @test
     */
    public function it_does_its_job()
    {
        $validator = new GitValidator(null);

        $git = $this->mockUtility("Git");

        $git->shouldReceive("isRepository")
            ->times(4)
            ->with(null)
            ->andReturn(false, true, true, true);

        $git->shouldReceive("getConfig")
            ->times(3)
            ->andReturn(
                [],
                ["remote.origin.url" => "foobar"],
                ["remote.origin.url" => "https://github.com/bound1ess/adviser.git"]
            );

        $validator->utility("Git", $git);

        // 1st scenario: not a Git repository.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isError());

        // 2nd scenario: Git repository.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isNormal());

        // Second step (if Git repository).
        // 1st scenario: no remote.origin.url property.
        $this->assertTrue($messages->last()->isError());

        // 2nd scenario: remote.origin.url is here, but doesn't point to Github or Bitbucket.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->last()->isWarning());

        // 3rd scenario: remote.origin.url is here and it points to Github/Bitbucket.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->last()->isNormal());
    }
}
