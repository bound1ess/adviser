<?php namespace Adviser\Output\Formatters;

use Adviser\Output\MessageBag, Adviser\Output\Message;

class PlainTextFormatterTest extends \Adviser\Testing\FormatterTestCase
{

    /**
     * @test
     */
    public function it_formats_the_given_set_of_messages()
    {
        $messages = [
            new Message("foo", Message::NORMAL),
            new Message("bar", Message::WARNING),
            new Message("baz", Message::ERROR),
        ];

        $bag = new MessageBag($messages);

        $output = (new PlainTextFormatter())->format($bag);

        $this->assertInternalType("string", $output);

        // Make testing a little bit easier.
        $lines = explode(PHP_EOL, $output);

        $this->assertCount(3 + 1, $lines);

        $this->assertEquals($lines[0], "1 OK, 1 WARNING(S), 1 ERROR(S)");
        $this->assertEquals($lines[1], "[OK] foo");
        $this->assertEquals($lines[2], "[WARNING] bar");
        $this->assertEquals($lines[3], "[ERROR] baz");
    }
}
