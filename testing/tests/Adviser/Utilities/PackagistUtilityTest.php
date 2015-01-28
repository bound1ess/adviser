<?php namespace Adviser\Utilities;

use GuzzleHttp\Exception\ClientException, GuzzleHttp\Message\Request;

class PackagistUtilityTest extends \Adviser\Testing\UtilityTestCase
{

    /**
     * @test
     */
    public function it_checks_if_given_package_was_published_to_Packagist()
    {
        $client = \Mockery::mock("GuzzleHttp\Client");

        $client->shouldReceive("get")
               ->once()
               ->with("https://packagist.org/packages/phpunit/phpunit.json")
               ->andReturn(true);

        $client->shouldReceive("get")
               ->once()
               ->with("https://packagist.org/packages/nonexistent/package.json")
               ->andThrow(new ClientException("message", new Request("method", "url")));

        $packagist = new PackagistUtility($client);

        $this->assertTrue($packagist->packageExists("phpunit/phpunit"));
        $this->assertFalse($packagist->packageExists("nonexistent/package"));
    }
}
