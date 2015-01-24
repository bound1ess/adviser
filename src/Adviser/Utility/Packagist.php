<?php namespace Adviser\Utility;

use Packagist\Api\Client;
// Guzzle ~3.0
use Guzzle\Http\Exception\ClientErrorResponseException;

class Packagist {

    /**
     * Check if package was published to Packagist.
     *
     * @param string $name
     * @return boolean
     */
    public function packageExists($name) {
        try {
            (new Client)->get($name);

            return true;
        } catch (ClientErrorResponseException $exception) {
            return false;
        }
    }
}
