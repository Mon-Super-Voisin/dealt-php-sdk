<?php

use Dealt\DealtSDK\GraphQL\Queries\OfferAvailabilityQuery;
use Dealt\DealtSDK\Utils\GraphQLFormatter;
use PHPUnit\Framework\TestCase;

final class OfferAvailabilityQueryTest extends TestCase
{
    public function testBuildsGraphqlFragment(): void
    {
        $query = <<<'GRAPHQL'
            query offerAvailability($apiKey: String!, $offerId: UUID!, $address: OfferAvailabilityQuery_Address!) {
                offerAvailability(apiKey: $apiKey, offerId: $offerId, address: $address) {
                    __typename
                    ... on OfferAvailabilityQuery_Success {
                        __typename
                        available
                        netPrice {
                            currencyCode
                            amount
                        }
                        grossPrice {
                            currencyCode
                            amount
                        }
                        vat {
                            currencyCode
                            amount
                        }
                    }
                    ... on OfferAvailabilityQuery_Failure {
                        __typename
                        reason
                    }
                }
            }
GRAPHQL;

        $this->assertEquals(GraphQLFormatter::formatQuery($query), OfferAvailabilityQuery::toQuery());
    }
}
