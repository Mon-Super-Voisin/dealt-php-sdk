<?php

namespace Dealt\DealtSDK\GraphQL\Types\Object;

use Dealt\DealtSDK\Exceptions\GraphQLException;
use Dealt\DealtSDK\GraphQL\GraphQLObjectInterface;

abstract class AbstractUnionType implements GraphQLObjectInterface
{
    /** @var string */
    public static $unionName;

    /** @var array<string, mixed> */
    public static $unionDefinition;

    public static function toFragment(): string
    {
        $unionFragment = array_map(function ($subType) {
            /** @var AbstractObjectType */
            $subClass = $subType;

            return <<<GRAPHQL
                ... on {$subClass::$objectName} {
                    __typename
                    {$subClass::toFragment()}
                }
            GRAPHQL;
        }, static::$unionDefinition);

        return join("\n", $unionFragment);
    }

    public static function fromJson($json): GraphQLObjectInterface
    {
        $typename   = $json->__typename;

        /** @var AbstractObjectType */
        $objectType = current(
            array_filter(
                static::$unionDefinition,
                function ($subType) use ($typename) {
                    /** @var AbstractObjectType */
                    $subClass = $subType;

                    return $subClass::$objectName == $typename;
                }
            )
        );

        return $objectType::fromJson($json);
    }

    /**
     * @throws GraphQLException
     */
    public function setProperty($key, $value): GraphQLObjectInterface
    {
        throw new GraphQLException('Cannot set property on union type');
    }
}
