<?php

use Dealt\DealtSDK\GraphQL\Queries\MissionQuery;
use Dealt\DealtSDK\Utils\GraphQLFormatter;
use PHPUnit\Framework\TestCase;

final class MissionQueryTest extends TestCase
{
    public function testBuildsGraphqlFragment(): void
    {
        $query = <<<'GRAPHQL'
            query mission($apiKey: String!, $missionId: String!) {
                mission(apiKey: $apiKey, missionId: $missionId) {
                    __typename
                    ... on MissionQuery_Success {
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
                    ... on MissionQuery_Failure {
                        __typename
                        reason
                    }
                }
            }
GRAPHQL;

        $this->assertEquals(GraphQLFormatter::formatQuery($query), MissionQuery::toQuery());
    }
}
