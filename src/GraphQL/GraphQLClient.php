<?php

namespace Dealt\DealtSDK\GraphQL;

use Dealt\DealtSDK\DealtEnvironment;
use Dealt\DealtSDK\Exceptions\GraphQLException;
use Dealt\DealtSDK\GraphQL\Types\Object\AbstractObjectType;
use Exception;

/**
 * Minimal GraphQL Client for interacting with the
 * Dealt API.
 */
class GraphQLClient
{
    /** @var array<string, string> available dealt endpoints */
    private static $ENDPOINTS = [
        DealtEnvironment::PRODUCTION => 'https://api.dealt.fr/graphql',
        DealtEnvironment::TEST       => 'https://api.test.dealt.fr/graphql',
    ];

    /** @var string */
    public $apiKey;

    private static $HEADERS = ['Content-Type: application/json'];

    public function __construct(string $apiKey, string $env)
    {
        $this->apiKey   = $apiKey;
        $this->endpoint = static::$ENDPOINTS[$env];
    }

    public function exec(GraphQLOperationInterface $query)
    {
        $query->setApiKey($this->apiKey);
        $query->validateQueryParameters();

        return $this->request($query);
    }

    /**
     * Undocumented function.
     *
     * @throws GraphQLException
     */
    private function request(GraphQLOperationInterface $query): AbstractObjectType
    {
        try {
            $context  = stream_context_create([
                'http' => [
                    'method'        => 'POST',
                    'header'        => $this->merge_headers(),
                    'content'       => json_encode([
                        'query'         => $query->toQuery(),
                        'operationName' => $query->getOperationName(),
                        'variables'     => $query->toQueryVariables(),
                    ]),
                    'ignore_errors' => true,
                ],
            ]);

            $result   = @file_get_contents($this->endpoint, false, $context);
        } catch (Exception $e) {
            throw new GraphQLException($e->getMessage());
        }

        return $query->parseResult($result);
    }

    private function merge_headers(): array
    {
        return array_merge(GraphQLClient::$HEADERS, []);
    }
}
