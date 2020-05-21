<?php
namespace CarloNicora\Minimalism\Services\Redis\Configurations;

use CarloNicora\Minimalism\Core\Services\Abstracts\AbstractServiceConfigurations;
use CarloNicora\Minimalism\Services\Redis\Events\RedisErrorEvents;
use Exception;

class RedisConfigurations extends AbstractServiceConfigurations {
    /** @var string  */
    private string $host;

    /** @var int  */
    private int $port;

    /** @var string  */
    private string $password;

    /**
     * redisConfigurations constructor.
     * @throws Exception
     */
    public function __construct()
    {
        if (!($redisConnection = getenv('MINIMALISM_SERVICE_REDIS_CONNECTION')) !== false) {
            RedisErrorEvents::CONFIGURATION_ERROR()->throw();
        }

        [
            $this->host,
            $this->port,
            $this->password,
        ] = explode(',', $redisConnection);
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }
}