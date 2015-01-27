<?php namespace Adviser\Validators;

class CodeStyleValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /**
     * @test
     */
    public function it_does_its_job()
    {
        // Setup.
        $validator = new CodeStyleValidator(null);

        $commandRunner = $this->mockUtility("CommandRunner");

        $commandRunner->shouldReceive("run")
                      ->twice()
                      ->andReturn(
                          ["stdout" => "I..F..E"], // 2nd scenario.
                          ["stdout" => "......."] // 3rd scenario.
                      );

        $file = $this->mockUtility("File");

        $file->shouldReceive("exists")
             ->times(3 + 2 + 1)
             ->andReturn(
                 false, false, false, // 1st scenario.
                 false, true, // 2nd scenario.
                 true // 3rd scenario.
             );

        $validator->utility("CommandRunner", $commandRunner);
        $validator->utility("File", $file);

        // Test.
        // 1st scenario: couldn't find the php-cs-fixer executable file.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isError());

        // 2nd scenario: PSR-2 coding standard violations.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isWarning());

        // 3rd scenario: everything is fine.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isNormal());
    }
}
