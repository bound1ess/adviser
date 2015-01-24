<?php namespace Adviser\Validators;

use Adviser\Messages\MessageBag;

abstract class AbstractValidator {

    /**
     * @var string
     */
    protected $directory;

    /**
     * @param string $directory
     * @return AbstractValidator
     */
    public function __construct($directory) {
        $this->directory = $directory;
    }

    /**
     * Do your thing.
     *
     * @return MessageBag
     */
    public abstract function handle();
}
