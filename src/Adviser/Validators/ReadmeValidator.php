<?php namespace Adviser\Validators;

use Adviser\Messages\MessageBag, Adviser\Messages\Message;

class ReadmeValidator extends AbstractValidator
{

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $bag = new MessageBag();

        $bag->throwIn($this->lookForReadmeFile());

        return $bag;
    }

    /**
     * @return Message
     */
    protected function lookForReadmeFile()
    {
        // @todo
        return new Message("", Message::ERROR);
    }
}
