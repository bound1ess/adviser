<?php namespace Adviser\Validators;

use Adviser\Messages\Message, Adviser\Messages\MessageBag;

class TestValidator extends AbstractValidator
{

    /**
     * @var array
     */
    protected $testingFrameworks = [
        "phpunit/phpunit", // PHPUnit.
        "phpspec/phpspec", // PhpSpec.
        "behat/behat", // Behat.
        "codeception/codeception", // Codeception.
        // More could be added via configuration file (@todo).
    ];

    /**
     * @var array
     */
    protected $frameworkToConfiguration = [
        "phpunit/phpunit"         => ["phpunit.xml", "phpunit.xml.dist"],
        "phpspec/phpspec"         => ["phpspec.yml", "phpspec.yml.dist"],
        "codeception/codeception" => ["codeception.yml"],
    ];

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = new MessageBag();

        $bag->throwIn($this->checkTestingFrameworksConfiguration());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function checkTestingFrameworksConfiguration()
    {
        // @todo
    }
}
