<?php namespace Adviser\Utility;

use GuzzleHttp\Client, GuzzleHttp\Exception\ClientException;

class Packagist
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client|null $client
     * @return Packagist
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client;
    }

    /**
     * Check if package was published to Packagist.
     *
     * @param string $name
     * @return boolean
     */
    public function packageExists($name)
    {
        try {
            $this->client->get("https://packagist.org/packages/{$name}.json");

            return true;
        } catch (ClientException $exception) {
            return false;
        }
    }
}
