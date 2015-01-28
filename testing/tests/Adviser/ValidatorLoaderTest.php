<?php namespace Adviser;

class ValidatorLoaderTest extends \Adviser\Testing\TestCase
{

    /**
     * @test
     */
    public function it_loads_validators_listed_in_the_configuration_file()
    {
        $validators = (new ValidatorLoader)->loadFromConfigurationFile();

        $this->assertInternalType("array", $validators);
        $this->assertNotCount(0, $validators);

        foreach ($validators as $validator) {
            $this->assertInstanceOf("Adviser\Validators\AbstractValidator", $validator);
        }
    }
}
