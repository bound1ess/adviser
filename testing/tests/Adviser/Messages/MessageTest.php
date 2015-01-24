<?php namespace Adviser\Messages;

class MessageTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_sets_level() {
        $message = new Message("some message", Message::NORMAL);
    }

    /** @test */ function it_throws_an_exception_if_invalid_level_is_passed() {
        $this->setExpectedException("InvalidArgumentException");

        new Message("some message", null);
    }
}
