<?php namespace Adviser\Validators;

class CIValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /**
     * @test
     */
    public function it_does_its_job()
    {
        // Setup.
        $validator = new CIValidator(null);

        $file = $this->mockUtility("File");

        $file->shouldReceive("exists")
             ->times(3)
             ->with("/.travis.yml")
             ->andReturn(false, true, true);

        $file->shouldReceive("read")
             ->twice()
             ->with("/.travis.yml")
             ->andReturn(null, null);

        $YAMLParser = $this->mockUtility("YAMLParser");

        $YAMLParser->shouldReceive("parse")
                   ->twice()
                   ->andReturn(
                       ["php" => ["5.1", "5.2", "5.3", "weird"]],
                       ["php" => ["5.4", "5.5", "5.6", "hhvm"]]
                   );

        $validator->utility("File", $file);
        $validator->utility("YAMLParser", $YAMLParser);

        // Test.
        // 1st scenario: no .travis.yml file was found in the root directory of the project.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isError());

        // 2nd scenario: .travis.yml file is present, but PHP versions are outdated.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isWarning());

        // 3rd scenario: everything is fine.
        $messages = $this->runValidator($validator);

        $this->assertTrue($messages->first()->isNormal());
    }
}
