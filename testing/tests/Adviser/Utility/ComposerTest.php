<?php namespace Adviser\Utility;

class ComposerTest extends \PHPUnit_Framework_TestCase
{

    /** @test */ public function it_checks_if_the_manifest_file_exists()
    {
        $composer = new Composer;

        $this->assertTrue($composer->manifestExists(ADVISER_DIR));
        $this->assertFalse($composer->manifestExists($_SERVER["HOME"]));
    }
}
