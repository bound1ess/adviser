<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

class GitValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /** @test */ public function it_does_its_job()
    {
        $validator = new GitValidator(null);

        $git = Mockery::mock("Adviser\Utility\Git");

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

        // First step: not a Git repository.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::ERROR);

        // First step: Git repository.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::NORMAL);

        // Second step (if Git repository).
        // 2nd step: no remote.origin.url property.
        $this->assertEquals($messages->last()->getLevel(), Message::ERROR);

        // 2nd step: remote.origin.url is here, but doesn't point to Github or Bitbucket.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->last()->getLevel(), Message::WARNING);

        // 2nd step: remote.origin.url is here and it points to Github/Bitbucket.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->last()->getLevel(), Message::NORMAL);
    }
}
