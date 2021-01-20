<?php
namespace CarloNicora\Minimalism\Services\Redis;

use CarloNicora\Minimalism\Interfaces\ServiceInterface;
use CarloNicora\Minimalism\Services\Redis\Exceptions\RedisConnectionException;
use CarloNicora\Minimalism\Services\Redis\Exceptions\RedisKeyNotFoundException;
use Exception;

class Redis implements ServiceInterface
{
    /** @var string  */
    private string $host;

    /** @var int  */
    private int $port;

    /** @var string  */
    private string $password;

    /** @var int|null  */
    private ?int $dbIndex;

    /** @var \Redis|null  */
    private ?\Redis $redis=null;

    /**
     * abstractApiCaller constructor.
     * @param string $MINIMALISM_SERVICE_REDIS_CONNECTION
     */
    public function __construct(string $MINIMALISM_SERVICE_REDIS_CONNECTION)
    {
        [
            $this->host,
            $this->port,
            $this->password,
            $this->dbIndex
        ] = array_pad(
            explode(',', $MINIMALISM_SERVICE_REDIS_CONNECTION),
            4,
            null
        );
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

        if (($dbIndex = $this->dbIndex) !== null){
            $this->redis->select($dbIndex);
        }

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
                if (!$this->redis->connect($this->host, $this->port, 2)) {
                    throw new RedisConnectionException('Unable to connect to redis');
                }
            } catch (Exception) {
                throw new RedisConnectionException('Unable to connect to redis');
            }
            if ($this->password !== null) {
                $this->redis->auth($this->password);
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
     * @param int|string|array $key
     * @throws RedisConnectionException
     */
    public function remove(int|string|array $key) : void
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

    /**
     *
     */
    public function initialise(): void {}

    /**
     * §
     */
    public function destroy(): void {}
}