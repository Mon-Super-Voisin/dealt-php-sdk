<?php

namespace Dealt\DealtSDK\Services;

use Dealt\DealtSDK\Exceptions\GraphQLFailureException;
use Dealt\DealtSDK\GraphQL\GraphQLObjectInterface;
use Dealt\DealtSDK\GraphQL\Mutations\SubmitMissionMutation;
use Dealt\DealtSDK\GraphQL\Types\Input\SubmitMissionMutationAddress;
use Dealt\DealtSDK\GraphQL\Types\Input\SubmitMissionMutationCustomer;
use Dealt\DealtSDK\GraphQL\Types\Object\SubmitMissionMutationFailure;
use Dealt\DealtSDK\GraphQL\Types\Object\SubmitMissionMutationSuccess;

class DealtMissions extends AbstractDealtService
{
    /**
     * Posts a mission to the Dealt API.
     *
     * @param array<string, mixed> $params SubmitMissionMutation parameters
     *                                     - offer_id(string) : the uuid of the dealt offer
     *                                     - address(array<string, mixed>) : customer address
     *                                     - customer(array<string, mixed>) : customer description
     *                                     - webhook(?string) : optional webhook url
     *
     * @throws GraphQLFailureException
     *
     * @return SubmitMissionMutationSuccess|SubmitMissionMutationFailure
     */
    public function submit(array $params): GraphQLObjectInterface
    {
        $mutation = new SubmitMissionMutation();
        if (isset($params['offer_id'])) {
            $mutation->setQueryVar('offerId', $params['offer_id']);
        }
        if (isset($params['address'])) {
            $mutation->setQueryVar('address', SubmitMissionMutationAddress::fromArray($params['address']));
        }
        if (isset($params['customer'])) {
            $mutation->setQueryVar('customer', SubmitMissionMutationCustomer::fromArray($params['customer']));
        }
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
