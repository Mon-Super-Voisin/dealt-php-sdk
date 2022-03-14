<?php

namespace Dealt\DealtSDK\GraphQL;

use Dealt\DealtSDK\GraphQL\Types\Input\AbstractInputType;

interface GraphQLInputInterface
{
    public function setProperty($key, $value): AbstractInputType;

    public function toArray(): array;

    public static function fromArray($array): AbstractInputType;
}
