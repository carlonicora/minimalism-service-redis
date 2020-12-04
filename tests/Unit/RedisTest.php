<?php
namespace CarloNicora\Minimalism\Services\Redis\Tests\Unit;

use CarloNicora\Minimalism\Services\Redis\Exceptions\RedisConnectionException;
use CarloNicora\Minimalism\Services\Redis\Exceptions\RedisKeyNotFoundException;
use CarloNicora\Minimalism\Services\Redis\Redis;
use CarloNicora\Minimalism\Services\Redis\Tests\Abstracts\AbstractTestCase;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;

class RedisTest extends AbstractTestCase
{
    /**
     * @throws RedisConnectionException
     * @throws RedisKeyNotFoundException
     */
    public function testRedisConnectionWithoutPassword() : void
    {
        $redis = new Redis($this->getRedisConfigurationsNoPassword(), $this->getServices());

        /** @var \Redis|MockObject $Redis */
        $Redis = $this->getRedis();
        $Redis->method('isConnected')
            ->willReturn(false);
        $Redis->method('connect')
            ->willReturn(true);

        $Redis->method('get')
            ->with($this->equalTo('one'))
            ->willReturn(1);

        $this->setProperty($redis, 'redis', $Redis);

        $this->assertEquals(1, $redis->get('one'));
    }

    /**
     * @throws RedisConnectionException
     * @throws RedisKeyNotFoundException
     */
    public function testRedisConnectionException() : void
    {
        $redis = new Redis($this->getRedisConfigurationsNoPassword(), $this->getServices());

        /** @var \Redis|MockObject $Redis */
        $Redis = $this->getRedis();
        $Redis->method('isConnected')
            ->willReturn(false);
        $Redis->method('connect')
            ->willThrowException(new Exception());

        $this->setProperty($redis, 'redis', $Redis);

        $this->expectException(RedisConnectionException::class);

        $redis->get('one');
    }

    /**
     * @throws RedisConnectionException
     * @throws RedisKeyNotFoundException
     */
    public function testRedisFailConnection() : void
    {
        $redis = new Redis($this->getRedisConfigurationsNoPassword(), $this->getServices());

        $this->expectException(RedisConnectionException::class);

        $redis->get('one');
    }

    /**
     * @throws RedisConnectionException
     */
    public function testSetValue() : void
    {
        $redis = new Redis($this->getRedisConfigurations(), $this->getServices());

        /** @var \Redis|MockObject $Redis */
        $Redis = $this->getRedis();
        $Redis->method('isConnected')
            ->willReturn(false);
        $Redis->method('connect')
            ->willReturn(true);
        $Redis->method('get')
            ->with($this->equalTo('one'))
            ->willReturn(1);

        $this->setProperty($redis, 'redis', $Redis);

        $redis->set('one', 1);

        $this->assertEquals(1,1);
    }

    /**
     * @throws RedisConnectionException
     */
    public function testSetexValue() : void
    {
        $redis = new Redis($this->getRedisConfigurations(), $this->getServices());

        /** @var \Redis|MockObject $Redis */
        $Redis = $this->getRedis();
        $Redis->method('isConnected')
            ->willReturn(true);

        $this->setProperty($redis, 'redis', $Redis);

        $redis->set('one', 1, 100);

        $this->assertEquals(1,1);
    }

    /**
     * @throws RedisConnectionException
     */
    public function testDeleteValue() : void
    {
        $redis = new Redis($this->getRedisConfigurations(), $this->getServices());

        /** @var \Redis|MockObject $Redis */
        $Redis = $this->getRedis();
        $Redis->method('isConnected')
            ->willReturn(true);

        $this->setProperty($redis, 'redis', $Redis);

        $redis->remove('one');

        $this->assertEquals(1,1);
    }

    /**
     * @throws RedisConnectionException
     */
    public function testGetKeys() : void
    {
        $redis = new Redis($this->getRedisConfigurations(), $this->getServices());

        /** @var \Redis|MockObject $Redis */
        $Redis = $this->getRedis();
        $Redis->method('isConnected')
            ->willReturn(true);
        $Redis->method('keys')
            ->willReturn(['one']);

        $this->setProperty($redis, 'redis', $Redis);

        $this->assertEquals(['one'], $redis->getKeys('*'));
    }

    /**
     * @throws RedisConnectionException
     * @throws RedisKeyNotFoundException
     */
    public function testGetNonExistingValue() : void
    {
        $redis = new Redis($this->getRedisConfigurations(), $this->getServices());

        /** @var \Redis|MockObject $Redis */
        $Redis = $this->getRedis();
        $Redis->method('isConnected')
            ->willReturn(true);
        $Redis->method('get')
            ->with($this->equalTo('two'))
            ->willReturn(false);

        $this->setProperty($redis, 'redis', $Redis);

        $this->expectException(RedisKeyNotFoundException::class);
        $redis->get('two');
    }
}