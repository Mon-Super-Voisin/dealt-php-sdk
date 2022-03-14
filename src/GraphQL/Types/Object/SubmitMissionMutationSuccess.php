<?php

namespace Dealt\DealtSDK\GraphQL\Types\Object;

/**
 * @property Mission $mission
 */
class SubmitMissionMutationSuccess extends AbstractObjectType
{
    public static $objectName       = 'SubmitMissionMutation_Success';
    public static $objectDefinition =  [
        'mission'  => [
            'objectType'  => 'Mission!',
            'objectClass' => Mission::class,
        ],
    ];

    public static function fromJson($json): SubmitMissionMutationSuccess
    {
        return parent::fromJson($json);
    }
}
