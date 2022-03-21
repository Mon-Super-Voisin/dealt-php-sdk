<?php

use Dealt\DealtSDK\DealtClient;
use Dealt\DealtSDK\DealtEnvironment;
use Dealt\DealtSDK\GraphQL\Types\Object\SubmitMissionMutationSuccess;
use Dealt\DealtSDK\Services\DealtMissions;
use PHPUnit\Framework\TestCase;

final class DealtMissionsTest extends TestCase
{
    protected $client;

    public function __construct()
    {
        parent::__construct();
        $this->client = new DealtClient([
            'api_key' => getenv('DEALT_TEST_API_KEY'),
            'env'     => DealtEnvironment::TEST,
        ]);
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
