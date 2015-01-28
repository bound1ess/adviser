<?php namespace Adviser\Output;

class MessageTest extends \Adviser\Testing\TestCase
{

    /**
     * @test
     */
    public function it_sets_the_message_text_and_type()
    {
        // A "normal" message.
        $message = new Message("some message", Message::NORMAL);

        $this->assertEquals($message->format(), "<info>some message</info>");
        $this->assertTrue($message->isNormal());

        // A warning message.
        $message = new Message("some message", Message::WARNING);

        $this->assertEquals($message->format(), "<comment>some message</comment>");
        $this->assertTrue($message->isWarning());

        // An error message.
        $message = new Message("some message", Message::ERROR);

        $this->assertEquals($message->format(), "<error>some message</error>");
        // Test the "$raw" flag.
        $this->assertEquals($message->format(true), "some message");

        $this->assertTrue($message->isError());
        // The the "getType" method.
        $this->assertEquals($message->getType(), Message::ERROR);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_invalid_type_was_passed()
    {
        $this->setExpectedException("InvalidArgumentException");

        new Message("some message", "invalid type");
    }
}
