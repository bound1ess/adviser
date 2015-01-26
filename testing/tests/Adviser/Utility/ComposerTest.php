<?php namespace Adviser\Utility;

use Mockery;

class ComposerTest extends \PHPUnit_Framework_TestCase
{

    /** @test */ public function it_checks_if_the_manifest_file_exists()
    {
        $composer = new Composer;

        $this->assertTrue($composer->manifestExists(ADVISER_DIR));
        $this->assertFalse($composer->manifestExists($_SERVER["HOME"]));
    }

    /** @test */ public function it_checks_if_the_manifest_file_is_valid()
    {
        $runner = Mockery::mock("Adviser\Utility\CommandRunner");
        $runner->shouldReceive("run")
               ->twice()
               ->with("composer validate")
               ->andReturn(
                   ["stdout" => "./composer.json is valid".PHP_EOL],
                   ["stdout" => "./composer.json is invalid"]
               );

        $composer = new Composer($runner);

        $this->assertTrue($composer->isManifestValid(ADVISER_DIR));
        $this->assertFalse($composer->isManifestValid(ADVISER_DIR));
    }

    /** @test */ public function it_checks_if_autoloader_was_configured_in_the_manifest_file()
    {
        $composer = new Composer();

        $this->assertFalse($composer->hasAutoloader(ADVISER_DIR, "psr-0"));
        $this->assertTrue($composer->hasAutoloader(ADVISER_DIR, "psr-4"));

        $this->assertEquals($composer->hasAutoloader($_SERVER["HOME"], "psr-4"), null);
    }

    /** @test */ public function it_returns_the_source_directories_listed_in_the_manifest()
    {
        $composer = new Composer();

        $this->assertCount(0, $composer->getSourceDirectories($_SERVER["HOME"]));
        $this->assertEquals($composer->getSourceDirectories(ADVISER_DIR), ["src/Adviser/"]);
    }

    /** @test */ public function it_returns_the_dependencies_list()
    {
        $composer = new Composer();

        $this->assertCount(0, $composer->getDependencies($_SERVER["HOME"]));
        $this->assertContains("symfony/console", $composer->getDependencies(ADVISER_DIR));
        $this->assertContains(
            "phpunit/phpunit", $composer->getDependencies(ADVISER_DIR, true)
        );
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
