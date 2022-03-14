<?php

use Dealt\DealtSDK\GraphQL\Mutations\SubmitMissionMutation;
use Dealt\DealtSDK\Utils\GraphQLFormatter;

it('create submitMission mutation correctly', function () {
    $fragment = <<<'GRAPHQL'
        mutation submitMission($apiKey: String!, $offerId: UUID!, $address: SubmitMissionMutation_Address!, $customer: SubmitMissionMutation_Customer!, $webHookUrl: String) {
        submitMission(apiKey: $apiKey, offerId: $offerId, address: $address, customer: $customer, webHookUrl: $webHookUrl) {
            __typename
            ... on SubmitMissionMutation_Success {
            __typename
            mission {
                id
            }
            }
            ... on SubmitMissionMutation_Failure {
            __typename
            reason
            }
        }
        }
    GRAPHQL;

    expect(GraphQLFormatter::formatQuery(SubmitMissionMutation::toQuery()))
        ->toEqual(GraphQLFormatter::formatQuery($fragment));
});
