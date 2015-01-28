<?php namespace Adviser\Output;

class Message
{

    /**
     * @var integer
     */
    const NORMAL = 2;

    /**
     * @var integer
     */
    const WARNING = 3;

    /**
     * @var integer
     */
    const ERROR = 4;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var integer
     */
    protected $type;

    /**
     * @param string $message
     * @param integer $type
     * @return Message
     */
    public function __construct($message, $type)
    {
        $this->message = (string) $message;
        $this->setType($type);
    }

    /**
     * Format the message depending on its type.
     *
     * @param boolean $raw
     * @return string
     */
    public function format($raw = false)
    {
        $type = $raw ? null : $this->type;

        switch($type) {
            case static::NORMAL:  return "<info>{$this->message}</info>";
            case static::WARNING: return "<comment>{$this->message}</comment>";
            case static::ERROR:   return "<error>{$this->message}</error>";

            default: return $this->message;
        }
    }

    /**
     * Whether it's a normal message.
     *
     * @return boolean
     */
    public function isNormal()
    {
        return $this->type == static::NORMAL;
    }

    /**
     * Whether it's a warning message.
     *
     * @return boolean
     */
    public function isWarning()
    {
        return $this->type == static::WARNING;
    }

    /**
     * Whether it's an error message.
     *
     * @return boolean
     */
    public function isError()
    {
        return $this->type == static::ERROR;
    }

    /**
     * Get the message type.
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Validate and set message type.
     *
     * @throws \InvalidArgumentException
     * @param integer $type
     * @return void
     */
    protected function setType($type)
    {
        if (! in_array($type, [static::NORMAL, static::WARNING, static::ERROR])) {
            throw new \InvalidArgumentException("Invalid message type: {$type}.");
        }

        $this->type = $type;
    }
}
