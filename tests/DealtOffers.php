<?php

use Dealt\DealtSDK\DealtClient;
use Dealt\DealtSDK\GraphQL\Types\Object\Money;

it('resolves offer availability correctly', function () {
    $client             = new DealtClient(['api_key' => 'PvJxbG2krSVel-s4AyH6aPK13vPkV9DE-1vt']);
    $offer_availability = $client->offers->availability([
        'offer_id' => 'db396b53-69a6-45a8-ad40-38ac497e3523',
        'address'  => [
            'country' => 'France',
            'zipCode' => '75016',
        ],
    ]);

    expect($offer_availability->available)->toBe(false);
    expect($offer_availability->netPrice)->toBeInstanceOf(Money::class);
    expect($offer_availability->grossPrice)->toBeInstanceOf(Money::class);
    expect($offer_availability->vat)->toBeInstanceOf(Money::class);
});
