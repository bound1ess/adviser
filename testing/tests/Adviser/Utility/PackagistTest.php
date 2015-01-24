<?php namespace Adviser\Utility;

class PackagistTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_checks_if_package_exists() {
        $packagist = new Packagist();

        $this->assertTrue($packagist->packageExists("phpunit/phpunit"));
        $this->assertFalse($packagist->packageExists("nonexistent/package"));
    }
}
