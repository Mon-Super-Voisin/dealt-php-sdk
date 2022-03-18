<?php

namespace Dealt\DealtSDK\GraphQL;

interface GraphQLOperationInterface
{
    public function setApiKey(string $apiKey): GraphQLOperationInterface;

    /**
     * @return string
     */
    public static function toQuery();

    /**
     * @return string
     */
    public static function getOperationName();

    /**
     * @return array<string, mixed>
     */
    public function toQueryVariables();

    public function parseResult(mixed $result): GraphQLObjectInterface;

    public function validateQueryParameters(): void;
}
