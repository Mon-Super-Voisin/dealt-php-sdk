<?php

namespace Dealt\DealtSDK\GraphQL\Types\Object;

/**
 * @property bool  $available
 * @property Money $netPrice
 * @property Money $grossPrice
 * @property Money $vat
 */
class OfferAvailabilityQuerySuccess extends AbstractObjectType
{
    public static $objectName       = 'OfferAvailabilityQuery_Success';
    public static $objectDefinition =  [
        'available' => 'Boolean!',
        'netPrice'  => [
            'objectType'  => 'Money!',
            'objectClass' => Money::class,
        ],
        'grossPrice' => [
            'objectType'  => 'Money!',
            'objectClass' => Money::class,
        ],
        'vat' => [
            'objectType'  => 'Money!',
            'objectClass' => Money::class,
        ],
    ];

    public static function fromJson($json): AbstractObjectType
    {
        return parent::fromJson($json);
    }
}
