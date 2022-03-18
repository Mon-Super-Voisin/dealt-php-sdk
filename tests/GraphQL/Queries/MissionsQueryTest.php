<?php

use Dealt\DealtSDK\GraphQL\Queries\MissionsQuery;
use Dealt\DealtSDK\Utils\GraphQLFormatter;
use PHPUnit\Framework\TestCase;

final class MissionsQueryTest extends TestCase
{
    public function testBuildsGraphqlFragment(): void
    {
        $query = <<<'GRAPHQL'
            query missions($apiKey: String!) {
                missions(apiKey: $apiKey) {
                    __typename
                    ... on MissionsQuery_Success {
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
                    ... on MissionsQuery_Failure {
                        __typename
                        reason
                    }
                }
            }
GRAPHQL;

        $this->assertEquals(GraphQLFormatter::formatQuery($query), MissionsQuery::toQuery());
    }
}
