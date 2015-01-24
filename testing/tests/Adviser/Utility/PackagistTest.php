<?php namespace Adviser\Utility;

use Mockery;
use Guzzle\Http\Exception\ClientErrorResponseException;

class PackagistTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_checks_if_package_exists() {
        $client = Mockery::mock("Packagist\Api\Client");
        $client->shouldReceive("get")
               ->once()
               ->with("phpunit/phpunit")
               ->andReturn(true);
        $client->shouldReceive("get")
               ->once()
               ->with("nonexistent/package")
               ->andThrow(new ClientErrorResponseException);

        $packagist = new Packagist($client);

        $this->assertTrue($packagist->packageExists("phpunit/phpunit"));
        $this->assertFalse($packagist->packageExists("nonexistent/package"));
    }

    public function tearDown() {
        Mockery::close();
    }
}
