<?php namespace Adviser\Utility;

use Mockery;

class GitTest extends \PHPUnit_Framework_TestCase
{

/** @test */ public function it_returns_the_tags_list()
 {
     $runner = $this->mockCommandRunner();
     $runner->shouldReceive("run")
               ->once()
               ->with("git tag")
               ->andReturn([
                   "stdout" => "0.0.0".PHP_EOL,
               ]);

     $this->assertEquals((new Git($runner))->getTags(), ["0.0.0"]);
 }

/** @test */ public function it_checks_if_git_repository_exists()
 {
     $git = new Git();

     $this->assertTrue($git->isRepository(getcwd()));
        // Unless....unless...
        $this->assertFalse($git->isRepository($_SERVER["HOME"]));
 }

/** @test */ public function it_returns_the_configuration_as_an_array()
 {
     $runner = $this->mockCommandRunner();
     $runner->shouldReceive("run")
               ->once()
               ->with("git config -l")
               ->andReturn("foo=bar".PHP_EOL."baz=fuz".PHP_EOL);

     $config = (new Git($runner))->getConfig();

     $this->assertArrayHasKey("baz", $config);
     $this->assertEquals($config["foo"], "bar");
 }

    public function tearDown()
    {
        Mockery::close();
    }

    protected function mockCommandRunner()
    {
        return Mockery::mock("Adviser\Utility\CommandRunner");
    }
}
