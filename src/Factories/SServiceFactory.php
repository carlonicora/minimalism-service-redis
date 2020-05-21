<?php
namespace carlonicora\minimalism\services\redis\Factories;

use carlonicora\minimalism\core\services\abstracts\abstractServiceFactory;
use carlonicora\minimalism\core\services\exceptions\configurationException;
use carlonicora\minimalism\core\services\factories\servicesFactory;
use carlonicora\minimalism\services\redis\Configurations\RRedisConfigurations;
use carlonicora\minimalism\services\redis\RRedis;

class SServiceFactory extends abstractServiceFactory {
    /**
     * serviceFactory constructor.
     * @param servicesFactory $services
     * @throws configurationException
     */
    public function __construct(servicesFactory $services) {
        $this->configData = new RRedisConfigurations();

        parent::__construct($services);
    }

    /**
     * @param servicesFactory $services
     * @return mixed|RRedis
     */
    public function create(servicesFactory $services) {
        return new RRedis($this->configData, $services);
    }
}