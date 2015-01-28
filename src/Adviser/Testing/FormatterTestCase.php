<?php namespace Adviser\Testing;

/**
 * @codeCoverageIgnore
 */
class FormatterTestCase extends TestCase
{

    /**
     * Mock a MessageBag using Mockery.
     *
     * @param array $messages
     * @return mixed
     */
    protected function mockMessageBag(array $messages = [])
    {
        $bag = \Mockery::mock("Adviser\Output\MessageBag");

        $bag->shouldReceive("getAll")->atLeast()->once()->andReturn($messages);

        return $bag;
    }

    /**
     * Mock a Message using Mockery.
     *
     * @param string $text
     * @param integer $type
     * @return mixed
     */
    protected function mockMessage($text, $type)
    {
        $message = \Mockery::mock("Adviser\Output\Message");

        $message->shouldReceive("getType")->atLeast()->once()->andReturn($type);
        $message->shouldReceive("format")->with(true)->atLeast()->once()->andReturn($text);

        return $message;
    }
}
