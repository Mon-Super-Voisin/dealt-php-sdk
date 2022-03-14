<?php

namespace Dealt\DealtSDK\Services;

use Dealt\DealtSDK\DealtClient;
use Dealt\DealtSDK\GraphQL\GraphQLClient;

abstract class AbstractDealtService
{
    /** @var DealtClient */
    protected $client;

    /**
     * @param DealtClient $client
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    public function getGQLClient(): GraphQLClient
    {
        return $this->client->gqlClient;
    }
}
