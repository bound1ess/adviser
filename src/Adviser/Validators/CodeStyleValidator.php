<?php namespace Adviser\Validators;

use Adviser\Messages\Message, Adviser\Messages\MessageBag;

class CodeStyleValidator extends AbstractValidator
{

    /**
     * @var string
     */
    protected $executable = "php-cs-fixer";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = new MessageBag();

        if ( ! $this->findPhpCsFixerExecutable()) {
            $bag->throwIn(new Message(
                "Couldn't find the php-cs-fixer executable file."
                ." Visit github.com/FriendsOfPHP/PHP-CS-Fixer to install PHP-CS-Fixer.",
                Message::ERROR
            ));
        }

        return $bag;
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

        // 2) See if it was installed globally via Composer.
        if ($this->utility("File")->exists($_SERVER["HOME"]."/.composer/bin/php-cs-fixer")) {
            return true;
        }

        // 3) See if it's in /usr/local/bin directory (obviously it doesn't work on Windows).
        if (DIRECTORY_SEPARATOR == "\\") {
            // Windows, give up.
            return false;
        }

        return $this->utility("File")->exists("/usr/local/bin/php-cs-fixer");
    }
}
