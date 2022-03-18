<?php

use Dealt\DealtSDK\DealtClient;
use Dealt\DealtSDK\DealtEnvironment;
use Dealt\DealtSDK\Exceptions\GraphQLException;
use Dealt\DealtSDK\GraphQL\Types\Object\OfferAvailabilityQuerySuccess;
use Dealt\DealtSDK\Services\DealtOffers;
use PHPUnit\Framework\TestCase;

final class DealtOffersTest extends TestCase
{
    protected $client;

    public function __construct()
    {
        parent::__construct();
        $this->client = new DealtClient(['api_key' => getenv("DEALT_TEST_API_KEY"), 'env' => DealtEnvironment::TEST]);
    }


    public function testResolvesOfferAvailability(): void
    {
        $service = new DealtOffers($this->client);

        $result = $service->availability([
            "offer_id" => getenv("DEALT_TEST_OFFER_ID"),
            "address" => [
                "country" => "France",
                "zipCode" => "92190"
            ]
        ]);

        $this->assertInstanceOf(OfferAvailabilityQuerySuccess::class, $result);
    }

    public function testShouldThrowWhenOfferAvailabilityProvidedInconsistentParams(): void
    {
        $this->expectException(GraphQLException::class);

        $service = new DealtOffers($this->client);
        $service->availability([]);
    }
}
