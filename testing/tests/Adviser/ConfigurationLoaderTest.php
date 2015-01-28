<?php namespace Adviser;

class ConfigurationLoaderTest extends Testing\TestCase
{

    /**
     * @test
     */
    public function it_loads_the_configuration_file()
    {
        // Mock Adviser\Utilities\FileUtility.
        $file = $this->mockUtility("File");

        $file->shouldReceive("exists")
             ->once()
             ->with(getcwd()."/adviser.yml")
             ->andReturn(true);

        $file->shouldReceive("read")
             ->once()
             ->with(ADVISER_DIR."/adviser-default.yml")
             ->andReturn(null);

        $file->shouldReceive("read")
             ->once()
             ->with(getcwd()."/adviser.yml")
             ->andReturn(null);

        // Mock Adviser\Utilities\YAMLParserUtility.
        $YAMLParser = $this->mockUtility("YAMLParser");

        $YAMLParser->shouldReceive("parse")
                   ->twice()
                   ->andReturn(["foo" => "bar", "qux" => 123], ["foo" => "baz"]);

        // Create a new instance of ConfigurationLoader.
        $loader = new ConfigurationLoader($file, $YAMLParser);

        $this->assertInternalType("array", $configuration = $loader->load(true));
        $this->assertEquals($configuration, ["foo" => "baz", "qux" => 123]);
    }
}
