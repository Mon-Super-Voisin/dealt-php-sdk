<?php

namespace Dealt\DealtSDK\GraphQL\Types\Object;

/**
 * @property string $id
 */
class Mission extends AbstractObjectType
{
    public static $objectName = 'Mission';

    public static $objectDefinition = ['id' => 'ID!'];

    public static function fromJson($json): Mission
    {
        return parent::fromJson($json);
    }
}
