<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

class SemVerValidatorTest extends ValidatorTestCase
{

    /** @test */ function it_does_its_job()
    {
        // Setup.
        $validator = new SemVerValidator(null);

        $git = Mockery::mock("Adviser\Utility\Git");

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
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::ERROR);

        // 2nd scenario: Git repository, but tags are not SemVer.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::WARNING);

        // 3rd scenario: Git repository, tags are fine, too.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::NORMAL);
    }
}
