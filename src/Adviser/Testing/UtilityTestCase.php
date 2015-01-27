<?php namespace Adviser\Testing;

/**
 * @codeCoverageIgnore
 */
class UtilityTestCase extends TestCase
{

    /**
     * Mock a utility class using Mockery.
     *
     * @param string $name
     * @return mixed
     */
    protected function mockUtility($name)
    {
        return \Mockery::mock("Adviser\Utility\\".$name);
    }
}
