<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

class GitValidatorTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_checks_if_git_repository_is_present() {
        $validator = new GitValidator(null);

        $git = $this->getGitUtilityMock();
        $git->shouldReceive("isRepository")
            ->twice()
            ->with(null)
            ->andReturn(false, true);

        $validator->utility("Git", $git);

        // Not a Git repository.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::ERROR);

        // Git repository.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::NORMAL);
    }

    protected function isMessageBag($value) {
        $this->assertInstanceOf("Adviser\Messages\MessageBag", $value);
    }

    protected function getGitUtilityMock() {
        return Mockery::mock("Adviser\Utility\Git");
    }

    public function tearDown() {
        Mockery::close();
    }
}
