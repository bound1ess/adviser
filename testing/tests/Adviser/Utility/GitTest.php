<?php namespace Adviser\Utility;

use Mockery;

class GitTest extends \PHPUnit_Framework_TestCase {

    /** @test */ function it_returns_the_tags_list() {
        $runner = Mockery::mock("Adviser\Utility\CommandRunner");
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
    }

    public function tearDown() {
        Mockery::close();
    }
}
