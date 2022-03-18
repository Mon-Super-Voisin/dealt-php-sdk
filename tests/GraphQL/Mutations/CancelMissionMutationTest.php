<?php

use Dealt\DealtSDK\GraphQL\Mutations\CancelMissionMutation;
use Dealt\DealtSDK\Utils\GraphQLFormatter;
use PHPUnit\Framework\TestCase;

final class CancelMissionMutationTest extends TestCase
{
    public function testBuildsGraphqlFragment(): void
    {
        $mutation = <<<'GRAPHQL'
            mutation cancelMission($apiKey: String!, $missionId: UUID!) {
                cancelMission(apiKey: $apiKey, missionId: $missionId) {
                    __typename
                    ... on CancelMissionMutation_Success {
                        __typename
                        mission {
                            id
                            offer {
                                id
                                name
                            }
                            status
                            createdAt
                        }
                    }
                    ... on CancelMissionMutation_Failure {
                        __typename
                        reason
                    }
                }
            }
GRAPHQL;

        $this->assertEquals(GraphQLFormatter::formatQuery($mutation), GraphQLFormatter::formatQuery(CancelMissionMutation::toQuery()));
    }
}
