<?php

namespace Dealt\DealtSDK\GraphQL\Types\Object;

use Dealt\DealtSDK\GraphQL\Types\Enum\MissionStatus;

/**
 * @property string                                                                                                            $id
 * @property Offer                                                                                                             $offer
 * @property string                                                                                                            $createdAt
 * @property MissionStatus::DRAFT|MissionStatus::SUBMITTED|MissionStatus::CANCELED|MissionStatus::ACCEPTED|MissionStatus::DONE $status
 *
 * @method Mission fromJson()
 */
class Mission extends AbstractObjectType
{
    public static $objectName = 'Mission';

    public static $objectDefinition = [
        'id'     => 'ID!',
        'offer'  => [
            'objectType'  => 'Offer!',
            'objectClass' => Offer::class,
        ],
        'status' => [
            'objectType'  => 'Offer!',
            'objectClass' => MissionStatus::class,
            'isEnum'      => true,
        ],
        'createdAt' => 'DateTime!',
    ];
}
