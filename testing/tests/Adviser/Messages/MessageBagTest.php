<?php namespace Adviser\Messages;

use Mockery;

class MessageBagTest extends \PHPUnit_Framework_TestCase
{

    protected $bag;

    public function setUp()
    {
        $this->bag = new MessageBag();
    }

    public function tearDown()
    {
        Mockery::close();
    }

    protected function createMessage()
    {
        return Mockery::mock("Adviser\Messages\Message");
    }

/** @test */ public function it_adds_a_message()
 {
     $this->assertCount(0, $this->bag->getAll());

     $this->bag->throwIn($message1 = $this->createMessage());
     $this->bag->throwIn($message2 = $this->createMessage());

     $this->assertCount(2, $this->bag->getAll());

     $this->assertEquals($this->bag->first(), $message1);
     $this->assertEquals($this->bag->last(), $message2);
 }
}
