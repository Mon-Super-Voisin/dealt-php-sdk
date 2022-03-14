<?php

use Dealt\DealtSDK\DealtClient;
use Dealt\DealtSDK\GraphQL\Types\Object\Mission;
use Dealt\DealtSDK\GraphQL\Types\Object\SubmitMissionMutationSuccess;

// it('submits new mission correctly', function () {
//     $client = new DealtClient(['api_key' => 'PvJxbG2krSVel-s4AyH6aPK13vPkV9DE-1vt']);
//     $result = $client->missions->submit([
//         'offer_id' => 'db396b53-69a6-45a8-ad40-38ac497e3523',
//         'customer' => [
//             'firstName'    => 'Shaquille',
//             'lastName'     => "O'Neal",
//             'emailAddress' => 'test@test.test',
//             'phoneNumber'  => '+33700000000',
//         ],
//         'address'  => [
//             'country' => 'France',
//             'zipCode' => '75016',
//         ],
//     ]);

//     expect($result)->toBeInstanceOf(SubmitMissionMutationSuccess::class);
//     expect($result->mission)->toBeInstanceOf(Mission::class);
// });
