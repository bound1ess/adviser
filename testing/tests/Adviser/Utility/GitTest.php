<?php namespace Adviser\Utility;

use Mockery;

class GitTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_returns_the_tags_list() {
        $runner = $this->mockCommandRunner();
        $runner->shouldReceive("run")
               ->once()
               ->with("git tag")
               ->andReturn([
                   "stdout" => "0.0.0".PHP_EOL,
               ]);

        $this->assertEquals((new Git($runner))->getTags(), ["0.0.0"]);
    }

    /** @test */ function it_checks_if_git_repository_exists() {
        $git = new Git;

        $this->assertTrue($git->isRepository(getcwd()));
        // Unless....unless...
        $this->assertFalse($git->isRepository($_SERVER["HOME"]));
    }

    /** @test */ function it_returns_the_configuration_as_an_array() {
        $runner = $this->mockCommandRunner();
        $runner->shouldReceive("run")
               ->once()
               ->with("git config -l")
               ->andReturn();

        $configKeys = array_keys((new Git($runner))->getConfig());

        // It is hard to do anything else here - otherwise some tests might be "unstable".
        $this->assertArrayHasKey("core.bare", $configKeys);
        $this->assertArrayHasKey("core.logallrefupdates", $configKeys);
        $this->assertArrayHasKey("core.filemode", $configKeys);
    }

    public function tearDown() {
        Mockery::close();
    }

    protected function mockCommandRunner() {
        return Mockery::mock("Adviser\Utility\CommandRunner");
    }
}
