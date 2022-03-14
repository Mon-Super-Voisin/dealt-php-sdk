<?php

use Dealt\DealtSDK\GraphQL\Types\Object\Money;
use Dealt\DealtSDK\GraphQL\Types\Object\OfferAvailabilityQueryFailure;
use Dealt\DealtSDK\GraphQL\Types\Object\OfferAvailabilityQueryResult;
use Dealt\DealtSDK\GraphQL\Types\Object\OfferAvailabilityQuerySuccess;
use Dealt\DealtSDK\Utils\GraphQLFormatter;

it('builds Money fragment correctly', function () {
    $fragment = <<<GRAPHQL
        currencyCode
        amount
    GRAPHQL;

    expect(GraphQLFormatter::formatQuery(Money::toFragment()))
        ->toEqual(GraphQLFormatter::formatQuery($fragment));
});

it('builds OfferAvailabilityQuerySuccess fragment correctly', function () {
    $fragment = <<<GRAPHQL
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
    GRAPHQL;

    expect(GraphQLFormatter::formatQuery(OfferAvailabilityQuerySuccess::toFragment()))
        ->toEqual(GraphQLFormatter::formatQuery($fragment));
});

it('builds OfferAvailabilityQueryFailure fragment correctly', function () {
    $fragment = 'reason';

    expect(GraphQLFormatter::formatQuery(OfferAvailabilityQueryFailure::toFragment()))
        ->toEqual(GraphQLFormatter::formatQuery($fragment));
});

it('builds OfferAvailabilityQueryResult fragment correctly', function () {
    $fragment = <<<GRAPHQL
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
    GRAPHQL;

    expect(GraphQLFormatter::formatQuery(OfferAvailabilityQueryResult::toFragment()))
        ->toEqual(GraphQLFormatter::formatQuery($fragment));
});
