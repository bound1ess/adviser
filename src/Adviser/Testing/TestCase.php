<?php namespace Adviser\Testing;

use Mockery;

/**
 * @codeCoverageIgnore
 */
class TestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * Mock a utility class using Mockery.
     *
     * @param string $name
     * @return mixed
     */
    protected function mockUtility($name)
    {
        return Mockery::mock("Adviser\Utility\\".$name);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
