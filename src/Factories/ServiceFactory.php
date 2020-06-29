<?php
namespace CarloNicora\Minimalism\Services\Redis\Factories;

use CarloNicora\Minimalism\Core\Services\Abstracts\AbstractServiceFactory;
use CarloNicora\Minimalism\Core\Services\Exceptions\ConfigurationException;
use CarloNicora\Minimalism\Core\Services\Factories\ServicesFactory;
use CarloNicora\Minimalism\Services\Redis\Configurations\RedisConfigurations;
use CarloNicora\Minimalism\Services\Redis\Redis;
use Exception;

class ServiceFactory extends AbstractServiceFactory {
    /**
     * serviceFactory constructor.
     * @param ServicesFactory $services
     * @throws ConfigurationException
     * @throws Exception
     */
    public function __construct(ServicesFactory $services)
    {
        $this->configData = new RedisConfigurations();

        parent::__construct($services);
    }

    /**
     * @param ServicesFactory $services
     * @return mixed|Redis
     */
    public function create(ServicesFactory $services) : Redis
    {
        return new Redis($this->configData, $services);
    }
}