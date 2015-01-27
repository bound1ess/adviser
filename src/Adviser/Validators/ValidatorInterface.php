<?php namespace Adviser\Validators;

interface ValidatorInterface
{

    /**
     * Do a thing.
     *
     * @return \Adviser\Messages\MessageBag
     */
    public function handle();

    /**
     * Get the validator's name.
     *
     * @return string
     */
    public function getName();
}
