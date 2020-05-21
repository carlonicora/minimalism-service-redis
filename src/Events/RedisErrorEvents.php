<?php
namespace CarloNicora\Minimalism\Services\Redis\Events;

use CarloNicora\Minimalism\Core\Events\Abstracts\AbstractErrorEvent;
use CarloNicora\Minimalism\Core\Events\Interfaces\EventInterface;
use CarloNicora\Minimalism\Core\Modules\Interfaces\ResponseInterface;

class RedisErrorEvents extends AbstractErrorEvent
{
    /** @var string  */
    protected string $serviceName='redis';

    public static function CONFIGURATION_ERROR() : EventInterface
    {
        return new self(1, ResponseInterface::HTTP_STATUS_412, 'MINIMALISM_SERVICE_REDIS_CONNECTION is a required configuration');
    }
}