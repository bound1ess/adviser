<?php namespace Adviser\Validators;

class TestValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /**
     * @test
     */
    public function it_does_its_job()
    {
        // Setup.
        $validator = new TestValidator(null);

        $file = $this->mockUtility("File");

        $file->shouldReceive("exists")
             ->times(3)
             ->andReturn(
                 false, false, // 2nd scenario.
                 true // 3rd scenario.
             );

        $composer = $this->mockUtility("Composer");

        $composer->shouldReceive("getDependencies")
                 ->times(3)
                 ->with(null, true)
                 ->andReturn(
                     ["weird/package", "behat/behat"],
                     ["phpspec/phpspec"],
                     ["phpunit/phpunit"]
                 );

        $validator->utility("File", $file);
        $validator->utility("Composer", $composer);

        // Test.
        // 1st scenario: no testing frameworks were found in your composer.json.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isError());

        // 2nd scenario: a testing framework is present, but no configuration file was found.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isWarning());

        // 3rd scenario: a testing framework is present, and it is configured.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isNormal());
    }
}
