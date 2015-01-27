<?php namespace Adviser\Utility;

class FileTest extends \Adviser\Testing\UtilityTestCase
{

    /** @test */ public function it_checks_if_file_or_directory_exists()
    {
        $file = new File;

        $this->assertTrue($file->exists(ADVISER_DIR));
        $this->assertTrue($file->exists(ADVISER_DIR."/composer.json"));

        $this->assertFalse($file->exists(ADVISER_DIR.uniqid()));
    }

    /** @test */ public function it_checks_if_any_of_given_files_or_directories_exists()
    {
        $file = new File;

        $this->assertTrue($file->anyExists(ADVISER_DIR, ["README.md", "readme"]));
        $this->assertTrue($file->anyExists(ADVISER_DIR, ["Src", "src"]));

        $this->assertFalse($file->anyExists(ADVISER_DIR, [uniqid()]));
    }
}
