<?php

namespace Dealt\DealtSDK\GraphQL\Types\Object;

/**
 * @property Mission[] $missions
 *
 * @method MissionsQuerySuccess fromJson()
 */
class MissionsQuerySuccess extends AbstractObjectType
{
    public static $objectName       = 'MissionsQuery_Success';
    public static $objectDefinition =  [
        'mission'  => [
            'objectType'  => '[Mission!]!',
            'objectClass' => Mission::class,
            'isArray'     => true,
            'proxy'       => 'missions', /* remove when type fixed on GraphQL API */
        ],
    ];
}
