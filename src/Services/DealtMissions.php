<?php

namespace Dealt\DealtSDK\Services;

use Dealt\DealtSDK\Exceptions\GraphQLFailureException;
use Dealt\DealtSDK\GraphQL\GraphQLObjectInterface;
use Dealt\DealtSDK\GraphQL\Mutations\SubmitMissionMutation;
use Dealt\DealtSDK\GraphQL\Types\Input\SubmitMissionMutationAddress;
use Dealt\DealtSDK\GraphQL\Types\Input\SubmitMissionMutationCustomer;
use Dealt\DealtSDK\GraphQL\Types\Object\SubmitMissionMutationFailure;
use Dealt\DealtSDK\GraphQL\Types\Object\SubmitMissionMutationSuccess;

/**
 * DealtMissions Service
 * - submit mission
 * - cancel mission
 * - missions
 * - mission.
 */
class DealtMissions extends AbstractDealtService
{
    /**
     * Posts a mission to the Dealt API.
     *
     * @param array{
     *      offer_id: string,
     *      address: array{
     *          country: string,
     *          zip_code: string,
     *          city?: string,
     *          street1?: string,
     *          street2?: string,
     *          company?: string
     *      },
     *      customer: array{
     *          first_name: string,
     *          last_name: string,
     *          email_address: string,
     *          phone_number: string
     *      },
     *      webhook?: string
     * } $params SubmitMissionMutation parameters
     *
     * @throws GraphQLFailureException
     *
     * @return SubmitMissionMutationSuccess|SubmitMissionMutationFailure
     */
    public function submit(array $params): GraphQLObjectInterface
    {
        $mutation = new SubmitMissionMutation();
        self::validateParameters($params, $mutation);

        $mutation->setQueryVar('offerId', $params['offer_id']);
        $mutation->setQueryVar('address', SubmitMissionMutationAddress::fromArray($params['address']));
        $mutation->setQueryVar('customer', SubmitMissionMutationCustomer::fromArray($params['customer']));

        if (isset($params['webhook'])) {
            $mutation->setQueryVar('webhook', $params['webhook']);
        }

        /** @var SubmitMissionMutationSuccess|SubmitMissionMutationFailure */
        $result = $this->getGQLClient()->exec($mutation);

        if ($result instanceof SubmitMissionMutationFailure) {
            throw new GraphQLFailureException($result->reason);
        }

        return $result;
    }
}
