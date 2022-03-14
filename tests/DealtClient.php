<?php

use Dealt\DealtSDK\DealtClient;
use Dealt\DealtSDK\DealtEnvironment;
use Dealt\DealtSDK\Exceptions\InvalidArgumentException;
use Dealt\DealtSDK\Services\DealtMissions;
use Dealt\DealtSDK\Services\DealtOffers;

it('initializes correctly when given correct params', function () {
    expect(new DealtClient(['api_key' => 'xxx', 'env' => DealtEnvironment::PRODUCTION]))->toBeInstanceOf(DealtClient::class);
});

it('initializes correctly when missing env', function () {
    expect(new DealtClient(['api_key' => 'xxx']))->toBeInstanceOf(DealtClient::class);
});

it('throws when missing api_key', function () {
    new DealtClient(['env' => DealtEnvironment::TEST]);
})->throws(InvalidArgumentException::class);

it('throws when given wrong api_key type', function () {
    new DealtClient(['api_key' => []]);
})->throws(InvalidArgumentException::class);

it('throws when given wrong env string', function () {
    new DealtClient(['env' => 'unsupported env']);
})->throws(InvalidArgumentException::class);

it('throws when given wrong env type', function () {
    new DealtClient(['env' => []]);
})->throws(InvalidArgumentException::class);

it('resolves missions service', function () {
    $client = new DealtClient(['api_key' => 'xxx']);
    expect($client->missions)->toBeInstanceOf(DealtMissions::class);
});

it('resolves offers service', function () {
    $client = new DealtClient(['api_key' => 'PvJxbG2krSVel-s4AyH6aPK13vPkV9DE-1vt']);
    expect($client->offers)->toBeInstanceOf(DealtOffers::class);
});
