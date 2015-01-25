<?php namespace Adviser\Validators;

use Adviser\Messages\Message, Adviser\Messages\MessageBag;

class LicenseValidator extends AbstractValidator
{

    /**
     * @var array
     */
    protected $files = ["License", "license"];

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = new MessageBag();

        $bag->throwIn($this->lookForLicenseFile());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function lookForLicenseFile()
    {
        $file = $this->utility("File");

        if ($file->exists($this->directory."/LICENSE")) {
            return new Message("Your project has a LICENSE file.", Message::NORMAL);
        }

        if ($file->anyExists($this->directory, $this->files)) {
            return new Message(
                "Looks like your project has a license file, but it's not LICENSE.",
                Message::WARNING
            );
        }

        return new Message("Your project doesn't have a license file.", Message::ERROR);
    }
}
