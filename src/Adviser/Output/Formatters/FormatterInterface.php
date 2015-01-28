<?php namespace Adviser\Output\Formatters;

use Adviser\Output\MessageBag;

interface FormatterInterface
{

    /**
     * Format the given set of messages.
     *
     * @param MessageBag $bag
     * @return string
     */
    public function format(MessageBag $bag);

    /**
     * Get the formatter's name.
     *
     * @return string
     */
    public function getName();
}
