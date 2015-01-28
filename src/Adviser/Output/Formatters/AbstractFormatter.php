<?php namespace Adviser\Output\Formatters;

use Adviser\Output\MessageBag;

abstract class AbstractFormatter implements FormatterInterface
{

    /**
     * @inheritdoc
     */
    abstract public function format(MessageBag $bag);

    /**
     * @inheritdoc
     */
    public function getName()
    {
        $chunks = explode("\\", get_class($this));

        return str_replace("Formatter", "", end($chunks));
    }
}
