<?php namespace Adviser\Utilities;

class FileUtilityTest extends \Adviser\Testing\UtilityTestCase
{

    /**
     * @test
     */
    public function it_checks_if_given_file_or_directory_exists()
    {
        $file = new FileUtility();

        $this->assertTrue($file->exists(ADVISER_DIR));
        $this->assertTrue($file->exists(ADVISER_DIR."/composer.json"));

        $this->assertFalse($file->exists(ADVISER_DIR.uniqid()));
    }

    /**
     * @test
     */
    public function it_checks_if_any_of_given_files_or_directories_exists()
    {
        $file = new FileUtility();

        $this->assertTrue($file->anyExists(ADVISER_DIR, ["README.md", "readme"]));
        $this->assertTrue($file->anyExists(ADVISER_DIR, ["Src", "src"]));

        $this->assertFalse($file->anyExists(ADVISER_DIR, [uniqid()]));
    }

    /**
     * @test
     */
    public function it_reads_a_file()
    {
        $file = new FileUtility();

        $this->assertEmpty($file->read(uniqid()));

        $this->assertNotEmpty($file->read(__FILE__));
    }
}
