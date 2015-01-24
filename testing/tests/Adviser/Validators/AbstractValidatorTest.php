<?php namespace Adviser\Validators;

class ConcreteValidator extends AbstractValidator {

    public function handle() {}
}

class AbstractValidatorTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_manages_utility_classes() {
        $validator = new ConcreteValidator(null);

        $this->assertInstanceOf("Adviser\Utility\Git", $instance = $validator->utility("Git"));
        $this->assertEquals($instance, $validator->utility("Git"));

        $this->assertEquals($instance, $validator->utility("Git", $instance));
    }
}
