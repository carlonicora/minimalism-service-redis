<?php
namespace carlonicora\minimalism\services\redis;

use carlonicora\minimalism\core\services\abstracts\abstractService;
use carlonicora\minimalism\core\services\factories\servicesFactory;
use carlonicora\minimalism\core\services\interfaces\serviceConfigurationsInterface;
use carlonicora\minimalism\services\redis\Configurations\RedisConfigurations;
use carlonicora\minimalism\services\redis\Exceptions\RedisConnectionException;
use carlonicora\minimalism\services\redis\Exceptions\RedisKeyNotFoundException;
use Exception;

class RRedis extends abstractService {
    /** @var RedisConfigurations  */
    private RedisConfigurations $configData;

    /** @var \Redis|null  */
    private ?\Redis $redis=null;

    /**
     * abstractApiCaller constructor.
     * @param serviceConfigurationsInterface $configData
     * @param servicesFactory $services
     */
    public function __construct(serviceConfigurationsInterface $configData, servicesFactory $services) {
        parent::__construct($configData, $services);

        /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
        $this->configData = $configData;
    }

    /**
     *
     * @throws RedisConnectionException
     */
    private function connect(): void {
        if ($this->redis === null) {
            $this->redis = new \Redis();
        }

        if (!$this->redis->isConnected()) {
            try {
                if (!$this->redis->connect($this->configData->host, $this->configData->port, 2)) {
                    throw new RedisConnectionException('Unable to connect to redis');
                }
            } catch (Exception $e) {
                throw new RedisConnectionException('Unable to connect to redis');
            }
            if ($this->configData->password !== null) {
                $this->redis->auth($this->configData->password);
            }
        }
    }

    /**
     * @param string $key
     * @return string
     * @throws RedisKeyNotFoundException
     * @throws RedisConnectionException
     */
    public function get(string $key) : string {
        $this->connect();

        $response = $this->redis->get($key);

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
    public function set(string $key, string $value, int $ttl=null): void {
        $this->connect();

        if ($ttl === null) {
            $this->redis->set($key, $value);
        } else {
            $this->redis->setex($key, $ttl, $value);
        }
    }

    /**
     * @param string $key
     * @throws RedisConnectionException
     */
    public function remove(string $key) : void {
        $this->connect();
        $this->redis->del($key);
    }

    /**
     * @param string $keyPattern
     * @return array
     * @throws RedisConnectionException
     */
    public function getKeys(string $keyPattern) : array {
        $this->connect();
        return $this->redis->keys($keyPattern);
    }
}