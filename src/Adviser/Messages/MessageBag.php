<?php namespace Adviser\Messages;

class MessageBag {

    /**
     * @var array
     */
    protected $messages;

    /**
     * @param array $messages
     * @return MessageBag
     */
    public function __construct(array $messages = []) {
        $this->messages = $messages;
    }

    /**
     * Add a new message to the bag.
     *
     * @param Message $message
     * @return void
     */
    public function throwIn(Message $message) {
        $this->messages[] = $message;
    }

    /**
     * Return all messages stored in the bag.
     *
     * @return array
     */
    public function getAll() {
        return $this->messages;
    }
}
