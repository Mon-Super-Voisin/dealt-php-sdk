<?php

namespace Dealt\DealtSDK\GraphQL;

use Dealt\DealtSDK\GraphQL\Types\Object\AbstractObjectType;

interface GraphQLOperationInterface
{
    public function setApiKey(string $apiKey);

    public static function toQuery();

    public static function getOperationName();

    public function toQueryVariables();

    public function parseResult($result): AbstractObjectType;

    public function validateQueryParameters();
}
