<?php

namespace Dealt\DealtSDK\GraphQL;

interface GraphQLObjectInterface
{
    public function setProperty($key, $value): GraphQLObjectInterface;

    public static function fromJson($json): GraphQLObjectInterface;

    public static function toFragment(): string;
}
