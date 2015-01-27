<?php namespace Adviser\Utility;

use Mockery;
use GuzzleHttp\Exception\ClientException, GuzzleHttp\Message\Request;

class PackagistTest extends \PHPUnit_Framework_TestCase
{

    /** @test */ public function it_checks_if_package_exists()
    {
        $client = Mockery::mock("GuzzleHttp\Client");

        $client->shouldReceive("get")
               ->once()
               ->with("https://packagist.org/packages/phpunit/phpunit.json")
               ->andReturn(true);

        $client->shouldReceive("get")
               ->once()
               ->with("https://packagist.org/packages/nonexistent/package.json")
               ->andThrow(new ClientException("message", new Request("method", "url")));

        $packagist = new Packagist($client);

        $this->assertTrue($packagist->packageExists("phpunit/phpunit"));
        $this->assertFalse($packagist->packageExists("nonexistent/package"));
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
