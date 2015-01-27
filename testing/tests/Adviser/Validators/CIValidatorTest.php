<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

// Mock for testing purposes.
function file_get_contents()
{
    return null;
}

class CIValidatorTest extends \Adviser\Testing\ValidatorTestCase
{

    /** @test */ public function it_does_its_job()
    {
        // Setup.
        $validator = new CIValidator(null);

        $file = Mockery::mock("Adviser\Utility\File");

        $file->shouldReceive("exists")
             ->times(3)
             ->with("/.travis.yml")
             ->andReturn(false, true, true);

        $YAMLParser = Mockery::mock("Adviser\Utility\YAMLParser");

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
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::ERROR);

        // 2nd scenario: .travis.yml file is present, but PHP versions are outdated.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::WARNING);

        // 3rd scenario: everything is fine.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::NORMAL);
    }
}
