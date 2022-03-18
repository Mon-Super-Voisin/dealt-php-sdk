<?php

namespace Dealt\DealtSDK\GraphQL;

interface GraphQLOperationInterface
{
    public function setApiKey(string $apiKey);

    public static function toQuery();

    public static function getOperationName();

    public function toQueryVariables();

    public function parseResult($result): GraphQLObjectInterface;

    public function validateQueryParameters();
}
