<?php namespace Adviser\Validators;

class ValidatorLoaderTest extends \PHPUnit_Framework_TestCase
{

    /** @test */ public function it_loads_validators_listed_in_the_config()
    {
        $this->assertInternalType("array", $validators = (new ValidatorLoader())->load());
        $this->assertNotCount(0, $validators);

        foreach ($validators as $validator) {
            $this->assertInstanceOf("Adviser\Validators\AbstractValidator", $validator);
        }
    }
}
