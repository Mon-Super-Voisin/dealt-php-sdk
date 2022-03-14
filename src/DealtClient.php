<?php

namespace Dealt\DealtSDK;

use Dealt\DealtSDK\Services;

class DealtClient extends CoreDealtClient
{
    private $serviceFactory;

    public function __get($name)
    {
        if (null === $this->serviceFactory) {
            $this->serviceFactory = new Services\DealtServiceFactory($this);
        }

        return $this->serviceFactory->__get($name);
    }
}
