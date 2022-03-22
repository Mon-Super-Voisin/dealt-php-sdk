<?php

use Dealt\DealtSDK\DealtClient;
use Dealt\DealtSDK\DealtEnvironment;
use Dealt\DealtSDK\GraphQL\GraphQLClient;
use Dealt\DealtSDK\GraphQL\Types\Object\MissionQuerySuccess;
use Dealt\DealtSDK\GraphQL\Types\Object\MissionsQuerySuccess;
use Dealt\DealtSDK\Services\DealtMissions;
use PHPUnit\Framework\TestCase;

final class DealtMissionsTest extends TestCase
{
    protected $client;
    protected $graphQLClientStub;

    public function __construct()
    {
        parent::__construct();
        $this->client = new DealtClient([
            'api_key' => "test-api-key",
            'env'     => DealtEnvironment::TEST,
        ]);

        $this->graphQLClientStub = $this->createPartialMock(GraphQLClient::class, ["request"]);
        $this->graphQLClientStub->apiKey = "test-api-key";
        $this->client->gqlClient = $this->graphQLClientStub;
    }

    public function testMissionsQueryOnSuccessfulResponse(): void
    {
        $service = new DealtMissions($this->client);
        $response = strval(json_encode([
            "data" => [
                "missions" => [
                    "__typename" => "MissionsQuery_Success",
                    "mission" => [
                        [
                            "id" => "mission-uuid-0001",
                            "status" => "SUBMITTED",
                            "createdAt" => "2022-03-22T08:18:02.278Z",
                            "offer" => [
                                "id" => "offer-uuid-0001",
                                "name" => "offer 0001"
                            ]
                        ]
                    ]
                ]
            ]
        ]));

        $this->graphQLClientStub->expects($this->once())->method("request")->willReturn($response);
        $result  = $service->all();

        $this->assertInstanceOf(MissionsQuerySuccess::class, $result);
    }

    public function testMissionQueryOnSuccessfulResponse(): void
    {
        $service = new DealtMissions($this->client);
        $response = strval(json_encode([
            "data" => [
                "mission" => [
                    "__typename" => "MissionQuery_Success",
                    "mission" =>
                    [
                        "id" => "mission-uuid-0001",
                        "status" => "SUBMITTED",
                        "createdAt" => "2022-03-22T08:18:02.278Z",
                        "offer" => [
                            "id" => "offer-uuid-0001",
                            "name" => "offer 0001"
                        ]
                    ]

                ]
            ]
        ]));

        $this->graphQLClientStub->expects($this->once())->method("request")->willReturn($response);
        $result  = $service->get("mission-uuid-0001");

        $this->assertInstanceOf(MissionQuerySuccess::class, $result);
    }

    // public function testSubmitMission(): void
    // {
    //     $service = new DealtMissions($this->client);

    //     $result  = $service->submit([
    //         'offer_id' => getenv('DEALT_TEST_OFFER_ID'),
    //         'address'  => [
    //             'country'  => 'France',
    //             'zip_code' => '92190',
    //         ],
    //         'customer' => [
    //             'first_name'    => 'Jean',
    //             'last_name'     => 'Dupont',
    //             'email_address' => 'xxx@yyy.zzz',
    //             'phone_number'  => '+33600000000',
    //         ],
    //     ]);

    //     $result->$this->assertInstanceOf(SubmitMissionMutationSuccess::class, $result);
    // }
}
