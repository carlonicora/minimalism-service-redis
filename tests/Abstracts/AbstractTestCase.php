<?php
namespace CarloNicora\Minimalism\Services\Redis\Tests\Abstracts;

use CarloNicora\Minimalism\Core\Services\Factories\ServicesFactory;
use CarloNicora\Minimalism\Services\Redis\Configurations\RedisConfigurations;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Redis;
use ReflectionClass;
use ReflectionException;

abstract class AbstractTestCase extends TestCase
{
    /**
     * @return ServicesFactory
     */
    protected function getServices() : ServicesFactory
    {
        return new ServicesFactory();
    }

    /**
     * @param string $name
     * @param string $value
     */
    protected function setEnv(string $name, string $value) : void
    {
        putenv($name.'='.$value);
    }

    /**
     * @return RedisConfigurations|MockObject
     */
    protected function getRedisConfigurations() : RedisConfigurations
    {
        /** @var MockObject|RedisConfigurations $response */
        $response = $this->getMockBuilder(RedisConfigurations::class)
            ->disableOriginalConstructor()
            ->getMock();

        $response->method('getHost')
            ->willReturn('host');

        $response->method('getPassword')
            ->willReturn('password');

        $response->method('getPort')
            ->willReturn(123);

        return $response;
    }

    /**
     * @return RedisConfigurations|MockObject
     */
    protected function getRedisConfigurationsNoPassword() : RedisConfigurations
    {
        /** @var MockObject|RedisConfigurations $response */
        $response = $this->getMockBuilder(RedisConfigurations::class)
            ->disableOriginalConstructor()
            ->getMock();

        $response->method('getHost')
            ->willReturn('host');

        $response->method('getPassword')
            ->willReturn(null);

        $response->method('getPort')
            ->willReturn(123);

        return $response;
    }

    /**
     * @return Redis
     */
    protected function getRedis() : Redis
    {
        /** @var MockObject|Redis $response */
        $response = $this->getMockBuilder(Redis::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $response;
    }

    /**
     * @param $object
     * @param $parameterName
     * @return mixed|null
     */
    protected function getProperty($object, $parameterName)
    {
        try {
            $reflection = new ReflectionClass(get_class($object));
            $property = $reflection->getProperty($parameterName);
            $property->setAccessible(true);
            return $property->getValue($object);
        } catch (ReflectionException $e) {
            return null;
        }
    }

    /**
     * @param $object
     * @param $parameterName
     * @param $parameterValue
     */
    protected function setProperty($object, $parameterName, $parameterValue): void
    {
        try {
            $reflection = new ReflectionClass(get_class($object));
            $property = $reflection->getProperty($parameterName);
            $property->setAccessible(true);
            $property->setValue($object, $parameterValue);
        } catch (ReflectionException $e) {
        }
    }
}