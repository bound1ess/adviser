<?php namespace Adviser\Validators;

use Adviser\Output\MessageBag, Adviser\Output\Message;

abstract class AbstractValidator implements ValidatorInterface
{

    /**
     * @var string
     */
    protected $directory;

    /**
     * @var array
     */
    protected $utilities = [];

    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * @param string $directory
     * @param array $configuration
     * @return AbstractValidator
     */
    public function __construct($directory, array $configuration = [])
    {
        $this->directory = $directory;
        $this->configuration = array_merge($this->configuration, $configuration);
    }

    /**
     * Do a thing.
     *
     * @return MessageBag
     */
    abstract public function handle();

    /**
     * Get an instance or set it (utility classes).
     *
     * @param string $name
     * @param mixed|null $instance
     * @return mixed
     */
    public function utility($name, $instance = null)
    {
        if (is_null($instance)) {
            if (! array_key_exists($name, $this->utilities)) {
                $class = "Adviser\Utilities\\".$name."Utility";

                return $this->utilities[$name] = new $class();
            }

            return $this->utilities[$name];
        }

        return $this->utilities[$name] = $instance;
    }

    /**
     * Get the validator's name.
     *
     * @return string
     */
    public function getName()
    {
        $chunks = explode("\\", get_class($this));

        return str_replace("Validator", "", end($chunks));
    }

    /**
     * Create a new MessageBag instance.
     *
     * @return MessageBag
     */
    public function createMessageBag()
    {
        return new MessageBag();
    }

    /**
     * Create a new message of type "normal".
     *
     * @param string $text
     * @return Message
     */
    public function createNormalMessage($text)
    {
        return new Message($text, Message::NORMAL);
    }

    /**
     * Create a new message of type "warning".
     *
     * @param string $text
     * @return Message
     */
    public function createWarningMessage($text)
    {
        return new Message($text, Message::WARNING);
    }

    /**
     * Create a new message of type "error".
     *
     * @param string $text
     * @return Message
     */
    public function createErrorMessage($text)
    {
        return new Message($text, Message::ERROR);
    }
}
