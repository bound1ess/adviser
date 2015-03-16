<?php namespace Adviser\Validators;

class CodeStyleValidator extends AbstractValidator
{

    /**
     * @var string
     */
    protected $executable = "php-cs-fixer";

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $bag = $this->createMessageBag();

        if ( ! $this->findPhpCsFixerExecutable()) {
            $bag->throwIn($this->createErrorMessage(
                "Couldn't find the php-cs-fixer executable file."
                ." Visit github.com/FriendsOfPHP/PHP-CS-Fixer to install PHP-CS-Fixer."
            ));
        } else {
            if ($this->runPhpCsFixer("psr2")) {
                $bag->throwIn($this->createNormalMessage(
                    "Your project follows the PSR-2 coding standard strictly."
                ));
            } else {
                $bag->throwIn($this->createWarningMessage(
                    "Your source code doesn't strictly follow the PSR-2 coding standard."
                ));
            }
        }

        return $bag;
    }

    /**
     * @param string $level
     * @return Message
     */
    protected function runPhpCsFixer($level)
    {
        $command = 
            "{$this->executable} fix {$this->directory} --dry-run --level={$level} --verbose";

        $output = $this->utility("CommandRunner")->run($command)["stdout"];

        return $output
            && count($lines = explode(PHP_EOL, $output))
            && $this->hasFixedFiles($lines[0]);
    }

    /**
     * @return boolean
     */
    protected function findPhpCsFixerExecutable()
    {
        // 1) Look for a PHAR in CWD.
        if ($this->utility("File")->exists($this->directory."/php-cs-fixer.phar")) {
            $this->executable = "./php-cs-fixer.phar";

            return true;
        }

        // 2) See if it's in /usr/local/bin directory (obviously it doesn't work on Windows).
        if (DIRECTORY_SEPARATOR == "/") {
            if ($this->utility("File")->exists("/usr/local/bin/php-cs-fixer")) {
                return true;
            }
        }

        // 3) See if it was installed globally via Composer.
        return $this->utility("File")->exists($_SERVER["HOME"]."/.composer/vendor/bin/php-cs-fixer");
    }

    /**
     * @param string $report
     * @return boolean
     */
    protected function hasFixedFiles($report)
    {
        foreach (str_split($report) as $marker) {
            if ($marker != ".") {
                return false;
            }
        }

        return true;
    }
}
