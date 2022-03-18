<?php

namespace Dealt\DealtSDK\GraphQL;

use Dealt\DealtSDK\DealtEnvironment;
use Dealt\DealtSDK\Exceptions\GraphQLException;
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

    /** @var string[] $HEADERS */
    private static $HEADERS = ['Content-Type: application/json'];

    /** @var string $apiKey */
    public $apiKey;

    /** @var string $endpoint */
    public $endpoint;


    /**
     * @param string $apiKey Dealt API key
     * @param string $env Dealt environment
     */
    public function __construct(string $apiKey, string $env)
    {
        $this->apiKey   = $apiKey;
        $this->endpoint = self::$ENDPOINTS[$env];
    }

    /**
     * Public request execution function
     * can be used for queries or mutations
     *
     * @param GraphQLOperationInterface $query
     * @return GraphQLObjectInterface
     */
    public function exec(GraphQLOperationInterface $operation): GraphQLObjectInterface
    {
        $operation->setApiKey($this->apiKey);
        $operation->validateQueryParameters();

        return $this->request($operation);
    }


    /**
     * Executes a GraphQL request to the Dealt API endpoint
     *
     * @param GraphQLOperationInterface $query
     * @return GraphQLObjectInterface
     * @throws GraphQLException
     */
    private function request(GraphQLOperationInterface $query): GraphQLObjectInterface
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

    /**
     * @return string[]
     */
    private function merge_headers(): array
    {
        return array_merge(GraphQLClient::$HEADERS, []);
    }
}
