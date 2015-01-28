<?php namespace Adviser\Validators;

class ConcreteValidator extends AbstractValidator
{

    public function handle()
    {
    }
}

class AbstractValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /**
     * @test
     */
    public function it_manages_utility_classes()
    {
        $validator = new ConcreteValidator(null);
        $instance = $validator->utility("Git");

        $this->assertInstanceOf("Adviser\Utilities\GitUtility", $instance);
        $this->assertEquals($instance, $validator->utility("Git"));
        $this->assertEquals($instance, $validator->utility("Git", $instance));
    }

    /**
     * @test
     */
    public function it_returns_the_validator_name()
    {
        $this->assertEquals((new ConcreteValidator(null))->getName(), "Concrete");
    }
}
