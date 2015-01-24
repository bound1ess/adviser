<?php namespace Adviser\Validators;

use Adviser\Messages\MessageBag;

abstract class AbstractValidator
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
     * @param  string            $directory
     * @return AbstractValidator
     */
    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    /**
     * Do your thing.
     *
     * @return MessageBag
     */
    abstract public function handle();

    /**
     * Get an instance or set it (utility classes).
     *
     * @param  string     $name
     * @param  mixed|null $instance
     * @return mixed
     */
    public function utility($name, $instance = null)
    {
        if (is_null($instance)) {
            if (! array_key_exists($name, $this->utilities)) {
                $class = "Adviser\Utility\\".$name;

                return $this->utilities[$name] = new $class();
            }

            return $this->utilities[$name];
        }

        return $this->utilities[$name] = $instance;
    }
}
