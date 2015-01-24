<?php namespace Adviser\Messages;

class MessageBag
{

    /**
     * @var array
     */
    protected $messages;

    /**
     * @param  array      $messages
     * @return MessageBag
     */
    public function __construct(array $messages = [])
    {
        $this->messages = $messages;
    }

    /**
     * Add a new message to the bag.
     *
     * @param  Message $message
     * @return void
     */
    public function throwIn(Message $message)
    {
        $this->messages[] = $message;
    }

    /**
     * Return all messages stored in the bag.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->messages;
    }

    /**
     * Get the first message stored (if present).
     *
     * @return Message|null
     */
    public function first()
    {
        return array_key_exists(0, $this->messages) ? $this->messages[0] : null;
    }

    /**
     * Get the last message (if there are any).
     *
     * @return Message|null
     */
    public function last()
    {
        return count($this->messages) > 0 ? end($this->messages) : null;
    }
}
