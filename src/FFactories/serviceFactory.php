<?php
namespace carlonicora\minimalism\services\redis\FFactories;

use carlonicora\minimalism\core\services\abstracts\abstractServiceFactory;
use carlonicora\minimalism\core\services\exceptions\configurationException;
use carlonicora\minimalism\core\services\factories\servicesFactory;
use carlonicora\minimalism\services\redis\CConfigurations\redisConfigurations;
use carlonicora\minimalism\services\redis\redis;

class serviceFactory extends abstractServiceFactory {
    /**
     * serviceFactory constructor.
     * @param servicesFactory $services
     * @throws configurationException
     */
    public function __construct(servicesFactory $services) {
        $this->configData = new redisConfigurations();

        parent::__construct($services);
    }

    /**
     * @param servicesFactory $services
     * @return mixed|redis
     */
    public function create(servicesFactory $services) {
        return new redis($this->configData, $services);
    }
}