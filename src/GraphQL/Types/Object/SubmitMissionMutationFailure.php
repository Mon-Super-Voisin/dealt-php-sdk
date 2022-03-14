<?php

namespace Dealt\DealtSDK\GraphQL\Types\Object;

use Dealt\DealtSDK\GraphQL\Types\Enum\SubmitMissionMutationFailureReason;

/**
 * @property string $reason
 */
class SubmitMissionMutationFailure extends AbstractObjectType
{
    public static $objectName       = 'SubmitMissionMutation_Failure';
    public static $objectDefinition =  [
        'reason'  => [
            'objectType'  => 'SubmitMissionMutation_FailureReason!',
            'objectClass' => SubmitMissionMutationFailureReason::class,
            'isEnum'      => true,
        ],
    ];

    public static function fromJson($json): SubmitMissionMutationFailure
    {
        return parent::fromJson($json);
    }
}
