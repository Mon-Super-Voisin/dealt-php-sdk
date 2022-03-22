<?php

use Dealt\DealtSDK\DealtClient;
use Dealt\DealtSDK\DealtEnvironment;
use Dealt\DealtSDK\Exceptions\GraphQLFailureException;
use Dealt\DealtSDK\Exceptions\InvalidArgumentException;
use Dealt\DealtSDK\GraphQL\GraphQLClient;
use Dealt\DealtSDK\GraphQL\Types\Object\OfferAvailabilityQuerySuccess;
use Dealt\DealtSDK\Services\DealtOffers;
use PHPUnit\Framework\TestCase;

final class DealtOffersTest extends TestCase
{
    protected $client;
    protected $graphQLClientStub;

    public function __construct()
    {
        parent::__construct();
        $this->client = new DealtClient([
            'api_key' => getenv('DEALT_TEST_API_KEY'),
            'env'     => DealtEnvironment::TEST,
        ]);

        $this->graphQLClientStub         = $this->createPartialMock(GraphQLClient::class, ['request']);
        $this->graphQLClientStub->apiKey = getenv('DEALT_TEST_API_KEY');
        $this->client->gqlClient         = $this->graphQLClientStub;
    }

    public function testResolvesOfferAvailability(): void
    {
        $service  = new DealtOffers($this->client);
        $response = strval(json_encode([
            'data' => [
                'offerAvailability' => [
                    '__typename' => 'OfferAvailabilityQuery_Success',
                    'available'  => true,
                    'netPrice'   => [
                        'amount'       => 70,
                        'currencyCode' => 'EUR',
                    ],
                    'grossPrice' => [
                        'amount'       => 84,
                        'currencyCode' => 'EUR',
                    ],
                    'vat' => [
                        'amount'       => 14,
                        'currencyCode' => 'EUR',
                    ],
                ],
            ],
        ]));

        $this->graphQLClientStub->expects($this->once())->method('request')->willReturn($response);

        $result  = $service->availability([
            'offer_id' => getenv('DEALT_TEST_OFFER_ID'),
            'address'  => [
                'country'  => 'France',
                'zip_code' => '92190',
            ],
        ]);

        $this->assertInstanceOf(OfferAvailabilityQuerySuccess::class, $result);
    }

    public function testThrowsOnAvailabilityFailure(): void
    {
        $this->expectException(GraphQLFailureException::class);

        $service  = new DealtOffers($this->client);
        $response = strval(json_encode([
            'data' => [
                'offerAvailability' => [
                    '__typename' => 'OfferAvailabilityQuery_Failure',
                    'reason'     => 'OFFER_NOT_FOUND',
                ],
            ],
        ]));

        $this->graphQLClientStub->expects($this->once())->method('request')->willReturn($response);

        $service->availability([
            'offer_id' => getenv('DEALT_TEST_OFFER_ID'),
            'address'  => [
                'country'  => 'France',
                'zip_code' => '92190',
            ],
        ]);
    }

    public function testShouldThrowWhenOfferAvailabilityProvidedInconsistentParams(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $service = new DealtOffers($this->client);
        $service->availability([]);
    }
}
