<?php
namespace CarloNicora\Minimalism\Services\Redis\Tests\Unit\Factories;

use CarloNicora\Minimalism\Services\Redis\Configurations\RedisConfigurations;
use CarloNicora\Minimalism\Services\Redis\Factories\ServiceFactory;
use CarloNicora\Minimalism\Services\Redis\Redis;
use CarloNicora\Minimalism\Services\Redis\Tests\Abstracts\AbstractTestCase;

class ServiceFactoryTest extends AbstractTestCase
{
    /**
     * @return ServiceFactory
     */
    public function testServiceInitialisation() : ServiceFactory
    {
        $response = new ServiceFactory($this->getServices());

        $this->assertEquals(1,1);

        return $response;
    }

    /**
     * @param ServiceFactory $service
     * @depends testServiceInitialisation
     */
    public function testServiceCreation(ServiceFactory $service) : void
    {
        $services = $this->getServices();
        $config = new RedisConfigurations();
        $poser = new Redis($config, $services);

        $this->assertEquals($poser, $service->create($services));
    }
}