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

        foreach ($this->checkTestingFrameworksConfiguration()->getAll() as $message) {
            $bag->throwIn($message);
        }

        return $bag;
    }

    /**
     * @return MessageBag
     */
    protected function checkTestingFrameworksConfiguration()
    {
        $packages = $this->utility("Composer")->getDependencies($this->directory, true);
        $bag = new MessageBag();

        foreach ($packages as $package) {
            if ( ! in_array($package, $this->testingFrameworks)) {
                continue; // This is not what we're looking for, skip.
            }

            if ( ! array_key_exists($package, $this->frameworkToConfiguration)) {
                continue; // This testing framework doesn't need a configuration file, skip.
            }

            foreach ($this->frameworkToConfiguration[$package] as $file) {
                // If there is a configuration file for this testing framework, that's cool.
                if ($this->utility("File")->exists($this->directory."/".$file)) {
                    // Add a message to the message bag.
                    $bag->throwIn(new Message(
                        "Testing framework {$package} is configured in ./{$file}.",
                        Message::NORMAL
                    ));
                }
            }
        }

        if (1 > count($bag->getAll())) {
            // If no messages were added, something is probably wrong.
            $bag->throwIn(new Message(
                "Looks like you don't test your code, do you?",
                Message::ERROR
            ));
        }

        return $bag;
    }
}
