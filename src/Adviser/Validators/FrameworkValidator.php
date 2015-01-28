<?php namespace Adviser\Validators;

class FrameworkValidator extends AbstractValidator
{

    /**
     * @var array
     */
    protected $frameworks = [
        // 5 most used PHP frameworks (as for now).
        "laravel/framework", // Laravel 5.
        "symfony/symfony", // Symfony 2.
        "yiisoft/yii2", // Yii 2.
        "zendframework/zendframework", // Zend 2.
        "cakephp/cakephp", // CakePHP 2.
        // More could be added via Adviser configuration file (@todo).
    ];

    public function handle()
    {
        $bag = $this->createMessageBag();

        $bag->throwIn($this->lookForFrameworksBeingUsed());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function lookForFrameworksBeingUsed()
    {
        foreach ($this->utility("Composer")->getDependencies($this->directory) as $package) {
            if (in_array($package, $this->frameworks)) {
                return $this->createWarningMessage("Your project depends on {$package}.");
            }
        }

        return $this->createNormalMessage(
            "Looks like your project doesn't depend on any framework."
        );
    }
}
