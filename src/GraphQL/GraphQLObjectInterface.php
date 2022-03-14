<?php

namespace Dealt\DealtSDK\GraphQL;

use Dealt\DealtSDK\GraphQL\Types\Object\AbstractObjectType;

interface GraphQLObjectInterface
{
    public function setProperty($key, $value): GraphQLObjectInterface;

    public static function fromJson($json): GraphQLObjectInterface;

    public static function toFragment(): string;
}
