<?php

namespace Dealt\DealtSDK\Services;

use Dealt\DealtSDK\Exceptions\GraphQLException;
use Dealt\DealtSDK\Exceptions\GraphQLFailureException;
use Dealt\DealtSDK\GraphQL\Queries\OfferAvailabilityQuery;
use Dealt\DealtSDK\GraphQL\Types\Input\OfferAvailabilityQueryAddress;
use Dealt\DealtSDK\GraphQL\Types\Object\OfferAvailabilityQueryFailure;
use Dealt\DealtSDK\GraphQL\Types\Object\OfferAvailabilityQuerySuccess;
use Exception;

class DealtOffers extends AbstractDealtService
{
    /**
     * Resolve the availability for a given offer id and
     * a customer address (at least a country and a zipCode).
     *
     * @param array<string, mixed> $params OfferAvailabilityQuery parameters
     *                                     - offer_id(string) : the uuid of the dealt offer
     *                                     - address(array<string, mixed>) : customer address
     *
     * @throws GraphQLFailureException|GraphQLException
     */
    public function availability(array $params): OfferAvailabilityQuerySuccess
    {
        try {
            $query = new OfferAvailabilityQuery();
            $query->setQueryVar('offerId', $params['offer_id']);
            $query->setQueryVar('address', OfferAvailabilityQueryAddress::fromArray($params['address']));

            /** @var OfferAvailabilityQuerySuccess|OfferAvailabilityQueryFailure */
            $result = $this->getGQLClient()->exec($query);

            if ($result instanceof OfferAvailabilityQueryFailure) {
                throw new GraphQLFailureException($result->reason);
            }

            return $result;
        } catch (Exception $e) {
            throw new GraphQLException("something went wrong");
        }
    }
}
