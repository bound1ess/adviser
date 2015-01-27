<?php namespace Adviser\Testing;

use Adviser\Validators\ValidatorInterface;

/**
 * @codeCoverageIgnore
 */
class ValidatorTestCase extends TestCase
{

    /**
     * Check whether passed value is a MessageBag instance and it's not empty (has messages).
     *
     * @param mixed $value
     * @return void
     */
    protected function isMessageBag($value)
    {
        $this->assertInstanceOf("Adviser\Messages\MessageBag", $value);
        $this->assertNotCount(0, $value->getAll());
    }

    /**
     * Run the given validator, pass the output to isMessageBag() and then return it.
     *
     * @param ValidatorInterface $validator
     * @return mixed
     */
    protected function runValidator(ValidatorInterface $validator)
    {
        $value = $validator->handle();

        $this->isMessageBag($value);

        return $value;
    }
}
