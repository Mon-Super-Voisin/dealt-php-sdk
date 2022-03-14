<?php

namespace Dealt\DealtSDK\GraphQL\Types\Object;

/**
 * @property string $id
 *
 * @method Mission fromJson()
 */
class Mission extends AbstractObjectType
{
    public static $objectName = 'Mission';

    public static $objectDefinition = ['id' => 'ID!'];
}
