<?php namespace Adviser\Validators;

class ValidatorLoader {

    /**
     * Load validators listed in the configuration file.
     *
     * @return array
     */
    public function load() {
        $config = require ADVISER_DIR."/config.php";
        $validators = [];

        foreach ($config["validators"] as $validator) {
            $validators[] = new $validator;
        }

        return $validators;
    }
}
