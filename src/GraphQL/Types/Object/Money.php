<?php

namespace Dealt\DealtSDK\GraphQL\Types\Object;

/**
 * @property string $currencyCode
 * @property float  $amount
 */
class Money extends AbstractObjectType
{
    public static $objectName = 'Money';

    public static $objectDefinition = [
        'currencyCode' => 'String!',
        'amount'       => 'Float!',
    ];

    public static function fromJson($json): Money
    {
        return parent::fromJson($json);
    }
}
