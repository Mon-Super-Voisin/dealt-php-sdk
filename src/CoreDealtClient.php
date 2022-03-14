<?php

namespace Dealt\DealtSDK;

use Dealt\DealtSDK\Exceptions\InvalidArgumentException;
use Dealt\DealtSDK\GraphQL\GraphQLClient;

/**
 * Client used to send requests to Stripe's API.
 *
 * @property \Dealt\DealtSDK\Services\DealtOffers   $offers
 * @property \Dealt\DealtSDK\Services\DealtMissions $missions
 */
class CoreDealtClient
{
    public $gqlClient;
    public const DEFAULT_CONFIG = [
        'env' => DealtEnvironment::TEST,
    ];

    /**
     * Initializes a new client
     * Configuration settings include the following options:.
     *
     * - api_key (string): The Dealt API Key to be used for internal GraphQL requests.
     * - env (null|string): The Dealt API Environment ("production"|"test") - defaults to test.
     *
     * @param array<string, mixed> $config an array containing the client configuration setttings
     */
    public function __construct($config = [])
    {
        if (!is_array($config)) {
            throw new InvalidArgumentException('$config must be an array');
        }
        $config = array_merge(DealtClient::DEFAULT_CONFIG, $config);
        $this->validateConfig($config);
        $this->gqlClient = new GraphQLClient($config['api_key'], $config['env']);
    }

    /**
     * @param array<string, mixed> $config the config object passed to the DealtClient constructor
     *
     * @throws InvalidArgumentException
     */
    private function validateConfig($config)
    {
        if (!isset($config['api_key']) || !is_string($config['api_key'])) {
            throw new InvalidArgumentException('api_key must be a string');
        }

        if (!isset($config['env']) || !is_string($config['env']) || !in_array($config['env'], [DealtEnvironment::PRODUCTION, DealtEnvironment::TEST])) {
            throw new InvalidArgumentException('env must be a string set to "production" or "test"');
        }
    }
}
