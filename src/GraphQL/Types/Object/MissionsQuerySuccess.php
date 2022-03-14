<?php

namespace Dealt\DealtSDK\GraphQL\Types\Object;

/**
 * @property array<Mission> $missions
 * @method MissionsQuerySuccess fromJson()
 */
class MissionsQuerySuccess extends AbstractObjectType
{
    public static $objectName       = 'MissionsQuery_Success';
    public static $objectDefinition =  [
        'mission'  => [
            'objectType'  => '[Mission!]',
            'objectClass' => Mission::class,
        ],
    ];
}
