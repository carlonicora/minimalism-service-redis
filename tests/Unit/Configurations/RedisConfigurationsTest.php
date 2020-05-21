<?php
namespace CarloNicora\Minimalism\Services\Redis\Tests\Unit\Configurations;

use CarloNicora\Minimalism\Services\Redis\Configurations\RedisConfigurations;
use CarloNicora\Minimalism\Services\Redis\Tests\Abstracts\AbstractTestCase;

class RedisConfigurationsTest extends AbstractTestCase
{
    public function testUnconfiguredConfiguration() : void
    {
        $this->expectExceptionCode(412);

        new RedisConfigurations();
    }

    public function testConfiguredConfigurationHost() : void
    {
        $this->setEnv('MINIMALISM_SERVICE_REDIS_CONNECTION', 'host,123,password');
        $config = new RedisConfigurations();

        $this->assertEquals('host', $config->getHost());
    }

    public function testConfiguredConfigurationPort() : void
    {
        $this->setEnv('MINIMALISM_SERVICE_REDIS_CONNECTION', 'host,123,password');
        $config = new RedisConfigurations();

        $this->assertEquals(123, $config->getPort());
    }

    public function testConfiguredConfigurationPassword() : void
    {
        $this->setEnv('MINIMALISM_SERVICE_REDIS_CONNECTION', 'host,123,password');
        $config = new RedisConfigurations();

        $this->assertEquals('password', $config->getPassword());
    }
}