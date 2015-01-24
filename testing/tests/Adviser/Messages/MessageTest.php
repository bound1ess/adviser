<?php namespace Adviser\Messages;

class MessageTest extends \PHPUnit_Framework_TestCase
{

/** @test */ public function it_sets_level()
 {
     $message = new Message("some message", Message::NORMAL);
     $this->assertEquals($message->format(), "<info>some message</info>");
     $this->assertEquals($message->getLevel(), Message::NORMAL);

     $message = new Message("some message", Message::WARNING);
     $this->assertEquals($message->format(), "<comment>some message</comment>");

     $message = new Message("some message", Message::ERROR);
     $this->assertEquals($message->format(), "<error>some message</error>");

     $this->assertEquals($message->format(true), "some message");
 }

/** @test */ public function it_throws_an_exception_if_invalid_level_is_passed()
 {
     $this->setExpectedException("InvalidArgumentException");

     new Message("some message", null);
 }
}
