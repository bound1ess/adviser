<?php namespace Adviser\Validators;

class GitValidatorTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_checks_if_git_repository_is_present() {
        $messages = (new GitValidator(null))->handle();
        $this->isMessageBag($messages);
    }

    protected function isMessageBag($value) {
        $this->assertInstanceOf("Adviser\Messages\MessageBag", $value);
    }
}
