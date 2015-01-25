<?php namespace Adviser\Validators;

/**
 * For testing purposes.
 *
 * @codeCoverageIgnore
 */
class ValidatorTestCase extends \PHPUnit_Framework_TestCase
{

    protected function isMessageBag($value)
    {
        $this->assertInstanceOf("Adviser\Messages\MessageBag", $value);
    }

    public function tearDown()
    {
        \Mockery::close();
    }
}
