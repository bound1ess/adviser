<?php namespace Adviser\Loaders;

class FormatterLoaderTest extends \Adviser\Testing\TestCase
{

    /**
     * @test
     */
    public function it_loads_formatters_listed_in_the_configuration_file()
    {
        $formatters = (new FormatterLoader())->loadFromConfigurationFile();

        $this->assertInternalType("array", $formatters);
        $this->assertNotCount(0, $formatters);

        foreach ($formatters as $formatter) {
            $this->assertInstanceOf("Adviser\Output\Formatters\AbstractFormatter", $formatter);
        }
    }
}
