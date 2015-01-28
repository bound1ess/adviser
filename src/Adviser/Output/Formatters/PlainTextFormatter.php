<?php namespace Adviser\Output\Formatters;

use Adviser\Output\MessageBag, Adviser\Output\Message;

class PlainTextFormatter extends AbstractFormatter
{

    /**
     * @inheritdoc
     */
    public function format(MessageBag $bag)
    {
        $output = [];

        $output[] = sprintf(
            "%s OK, %s WARNING(S), %s ERROR(S)",
            count($bag->getNormalMessages()),
            count($bag->getWarnings()),
            count($bag->getErrors())
        );

        foreach ($bag->getAll() as $message) {
            $output[] = sprintf("[%s] %s",
                $this->formatType($message),
                $message->format(true)
            );
        }

        return implode(PHP_EOL, $output);
    }

    /**
     * Format the message's type: "OK", "WARNING" or "ERROR".
     *
     * @param Message $message
     * @return string
     */
    protected function formatType(Message $message)
    {
        if ($message->isNormal()) {
            return "OK";
        }

        if ($message->isWarning()) {
            return "WARNING";
        }

        return "ERROR";
    }
}
