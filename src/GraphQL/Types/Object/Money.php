<?php

namespace Dealt\DealtSDK\GraphQL\Types\Object;

/**
 * @property string $currencyCode
 * @property float  $amount
 *
 * @method Money fromJson()
 */
class Money extends AbstractObjectType
{
    public static $objectName = 'Money';

    public static $objectDefinition = [
        'currencyCode' => 'String!',
        'amount'       => 'Float!',
    ];
}
