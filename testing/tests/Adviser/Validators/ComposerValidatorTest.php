<?php namespace Adviser\Validators;

use Mockery;
use Adviser\Messages\Message;

class ComposerValidatorTest extends ValidatorTestCase
{

    /** @test */ public function it_does_its_job()
    {
        // Setup.
        $validator = new ComposerValidator(null);
        $this->mockUtilities($validator);

        // Test.
        // 1st scenario: the manifest was not found/invalid.
        $messages = $validator->handle();
        $this->isMessageBag($messages);

        $this->assertEquals($messages->first()->getLevel(), Message::ERROR);
    }

    protected function mockUtilities(ComposerValidator $validator)
    {
        $packagist = Mockery::mock("Adviser\Utility\Packagist");

        $packagist->shouldReceive("packageExists")
                  ->twice()
                  ->with("test/package")
                  ->andReturn(false, true);

        $composer = Mockery::mock("Adviser\Utility\Composer");

        $composer->shouldReceive("readManifest")
                 ->twice()
                 ->with(null)
                 ->andReturn(["name" => "test/package"]);

        $composer->shouldReceive("isManifestValid")
                 ->twice()
                 ->with(null)
                 ->andReturn(false, true);

        $composer->shouldReceive("hasAutoloader")
                 ->twice()
                 ->with(null, "psr-4")
                 ->andReturn(false, true);

        $composer->shouldReceive("getSourceDirectories")
                 ->twice()
                 ->with(null)
                 ->andReturn(false, true);

        $validator->utility("Packagist", $packagist);
        $validator->utility("Composer", $composer);
    }
}
