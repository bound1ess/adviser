<?php namespace Adviser\Output;

class MessageBagTest extends \Adviser\Testing\TestCase
{

    /**
     * @test
     */
    public function it_manages_messages()
    {
        $bag = new MessageBag();

        // Assert that there are no messages in the bag.
        $this->assertCount(0, $bag->getAll());

        // Add a bunch of them.
        $bag->throwIn($first = $this->createMessage(Message::NORMAL));
        $bag->throwIn($this->createMessage(Message::WARNING));
        $bag->throwIn($last = $this->createMessage(Message::ERROR));

        // Make sure it gets updated.
        $this->assertCount(3, $bag->getAll());

        // Test various getters.
        $this->assertCount(1, $bag->getNormalMessages());
        $this->assertCount(1, $bag->getWarnings());
        $this->assertCount(1, $bag->getErrors());

        // And these two as well.
        $this->assertEquals($bag->first(), $first);
        $this->assertEquals($bag->last(), $last);
    }

    protected function createMessage($type)
    {
        $message = \Mockery::mock("Adviser\Output\Message");

        $message->shouldReceive("getType")->atLeast()->once()->andReturn($type);

        return $message;
    }
}
