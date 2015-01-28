<?php namespace Adviser\Utilities;

class GitUtilityTest extends \Adviser\Testing\UtilityTestCase
{

    /** @test */ public function it_returns_the_tags_list()
    {
        $runner = $this->mockUtility("CommandRunner");

        $runner->shouldReceive("run")
               ->once()
               ->with("git tag")
               ->andReturn([
                   "stdout" => "0.0.0".PHP_EOL,
               ]);

        $this->assertEquals((new GitUtility($runner))->getTags(), ["0.0.0"]);
    }

    /** @test */ public function it_checks_if_git_repository_exists()
    {
        $git = new GitUtility();

        $this->assertTrue($git->isRepository(getcwd()));
        $this->assertFalse($git->isRepository($_SERVER["HOME"]));
    }

    /** @test */ public function it_returns_the_configuration_as_an_array()
    {
        $runner = $this->mockUtility("CommandRunner");

        $runner->shouldReceive("run")
               ->once()
               ->with("git config -l")
               ->andReturn(["stdout" => "foo=bar".PHP_EOL."baz=fuz".PHP_EOL]);

        $config = (new GitUtility($runner))->getConfig();

        $this->assertArrayHasKey("baz", $config);
        $this->assertEquals($config["foo"], "bar");
    }
}
