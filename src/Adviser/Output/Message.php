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
    protected $level;

    /**
     * @param string $message
     * @param int $level
     * @return Message
     */
    public function __construct($message, $level)
    {
        $this->message = (string) $message;
        $this->setLevel($level);
    }

    /**
     * Format the message depending on its level.
     *
     * @param boolean $raw
     * @return string
     */
    public function format($raw = false)
    {
        $level = $raw ? null : $this->level;

        if ($level == static::NORMAL) {
            return "<info>{$this->message}</info>";
        }

        if ($level == static::WARNING) {
            return "<comment>{$this->message}</comment>";
        }

        if ($level == static::ERROR) {
            return "<error>{$this->message}</error>";
        }

        return $this->message;
    }

    /**
     * Get the message level.
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Whether it's a normal message.
     *
     * @return boolean
     */
    public function isNormal()
    {
        return $this->level == static::NORMAL;
    }

    /**
     * Whether it's a warning message.
     *
     * @return boolean
     */
    public function isWarning()
    {
        return $this->level == static::WARNING;
    }

    /**
     * Whether it's an error message.
     *
     * @return boolean
     */
    public function isError()
    {
        return $this->level == static::ERROR;
    }

    /**
     * Validate and set appropriate level.
     *
     * @throws \InvalidArgumentException
     * @param integer $level
     * @return void
     */
    protected function setLevel($level)
    {
        if (! in_array($level, [static::NORMAL, static::WARNING, static::ERROR])) {
            throw new \InvalidArgumentException("Invalid message level: {$level}.");
        }

        $this->level = $level;
    }
}
