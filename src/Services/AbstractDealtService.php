<?php

namespace Dealt\DealtSDK\Services;

use Dealt\DealtSDK\GraphQL\GraphQLClient;

abstract class AbstractDealtService
{
    /** @var GraphQLClient */
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function getGQLClient(): GraphQLClient
    {
        return $this->client->gqlClient;
    }
}
