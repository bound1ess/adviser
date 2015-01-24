<?php namespace Adviser\Utility;

use Packagist\Api\Client;
// Guzzle ~3.0
use Guzzle\Http\Exception\ClientErrorResponseException;

class Packagist {

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     * @return Packagist
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * Check if package was published to Packagist.
     *
     * @param string $name
     * @return boolean
     */
    public function packageExists($name) {
        try {
            $this->client->get($name);

            return true;
        } catch (ClientErrorResponseException $exception) {
            return false;
        }
    }
}
