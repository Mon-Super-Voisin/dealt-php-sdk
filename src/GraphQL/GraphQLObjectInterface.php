<?php

namespace Dealt\DealtSDK\GraphQL;

use Dealt\DealtSDK\GraphQL\Types\Object\AbstractObjectType;

interface GraphQLObjectInterface
{
    public function setProperty($key, $value): AbstractObjectType;

    public static function fromJson($json): AbstractObjectType;

    public static function toFragment(): string;
}
