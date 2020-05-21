<?php
namespace CarloNicora\Minimalism\Services\Redis;

use CarloNicora\Minimalism\Core\Services\Abstracts\AbstractService;
use CarloNicora\Minimalism\Core\Services\Factories\ServicesFactory;
use CarloNicora\Minimalism\Core\Services\Interfaces\ServiceConfigurationsInterface;
use CarloNicora\Minimalism\Services\Redis\Configurations\RedisConfigurations;
use CarloNicora\Minimalism\Services\Redis\Exceptions\RedisConnectionException;
use CarloNicora\Minimalism\Services\Redis\Exceptions\RedisKeyNotFoundException;
use Exception;

class Redis extends AbstractService {
    /** @var RedisConfigurations  */
    private RedisConfigurations $configData;

    /** @var \Redis|null  */
    private ?\Redis $redis=null;

    /**
     * abstractApiCaller constructor.
     * @param ServiceConfigurationsInterface $configData
     * @param ServicesFactory $services
     */
    public function __construct(ServiceConfigurationsInterface $configData, ServicesFactory $services)
    {
        parent::__construct($configData, $services);

        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->configData = $configData;
    }

    /**
     * @return \Redis
     * @throws RedisConnectionException
     */
    private function getRedis() : \Redis
    {
        if ($this->redis === null) {
            $this->redis = new \Redis();
        }

        $this->connect();

        return $this->redis;
    }

    /**
     *
     * @throws RedisConnectionException
     */
    private function connect(): void
    {
        if (!$this->redis->isConnected()) {
            try {
                if (!$this->redis->connect($this->configData->getHost(), $this->configData->getPort(), 2)) {
                    throw new RedisConnectionException('Unable to connect to redis');
                }
            } catch (Exception $e) {
                throw new RedisConnectionException('Unable to connect to redis');
            }
            if ($this->configData->getPassword() !== null) {
                $this->redis->auth($this->configData->getPassword());
            }
        }
    }

    /**
     * @param string $key
     * @return string
     * @throws RedisKeyNotFoundException|RedisConnectionException
     */
    public function get(string $key) : string
    {
        $response = $this->getRedis()->get($key);

        if ($response === false) {
            throw new RedisKeyNotFoundException('Key not found');
        }

        return $response;
    }

    /**
     * @param string $key
     * @param string $value
     * @param int|null $ttl
     * @throws RedisConnectionException
     */
    public function set(string $key, string $value, int $ttl=null): void
    {
        if ($ttl === null) {
            $this->getRedis()->set($key, $value);
        } else {
            $this->getRedis()->setex($key, $ttl, $value);
        }
    }

    /**
     * @param string $key
     * @throws RedisConnectionException
     */
    public function remove(string $key) : void
    {
        $this->getRedis()->del($key);
    }

    /**
     * @param string $keyPattern
     * @return array
     * @throws RedisConnectionException
     */
    public function getKeys(string $keyPattern) : array
    {
        return $this->getRedis()->keys($keyPattern);
    }
}