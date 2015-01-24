<?php namespace Adviser\Messages;

class MessageTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_sets_level() {
        $message = new Message("some message", Message::NORMAL);
        $this->assertEquals($message->format(), "<info>some message</info>");

        $message = new Message("some message", Message::WARNING);
        $this->assertEquals($message->format(), "<comment>some message</comment>");

        $message = new Message("some message", Message::ERROR);
        $this->assertEquals($message->format(), "<error>some message</error>");
    }

    /** @test */ function it_throws_an_exception_if_invalid_level_is_passed() {
        $this->setExpectedException("InvalidArgumentException");

        new Message("some message", null);
    }
}
