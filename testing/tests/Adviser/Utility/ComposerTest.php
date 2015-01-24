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

    public function tearDown()
    {
        Mockery::close();
    }
}
