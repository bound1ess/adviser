<?php namespace Adviser\Messages;

use Mockery;

class MessageBagTest extends \PHPUnit_Framework_TestCase {

    protected $bag;

    public function setUp() {
        $this->bag = new MessageBag;
    }

    public function tearDown() {
        Mockery::close();
    }

    protected function createMessage() {
        return Mockery::mock("Adviser\Messages\Message");
    }

    /** @test */ function it_adds_a_message() {
        $this->assertCount(0, $this->bag->getAll());
        $this->bag->throwIn($this->createMessage());
        $this->bag->throwIn($this->createMessage());
        $this->assertCount(2, $this->bag->getAll());
    }
}
