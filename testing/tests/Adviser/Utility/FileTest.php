<?php namespace Adviser\Utility;

class FileTest extends \PHPUnit_Framework_TestCase
{

    /** @test */ public function it_checks_if_file_or_directory_exists()
    {
        $file = new File;

        $this->assertTrue($file->exists(ADVISER_DIR));
        $this->assertTrue($file->exists(ADVISER_DIR."/composer.json"));

        $this->assertFalse($file->exists(ADVISER_DIR.uniqid()));
    }
}
