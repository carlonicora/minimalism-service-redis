<?php
namespace carlonicora\minimalism\services\redis\configurations;

use carlonicora\minimalism\core\services\abstracts\abstractServiceConfigurations;
use carlonicora\minimalism\core\services\exceptions\configurationException;

class redisConfigurations extends abstractServiceConfigurations {
    /** @var string  */
    public string $host;

    /** @var int  */
    public int $port;

    /** @var string  */
    public string $password;

    /**
     * redisConfigurations constructor.
     * @throws configurationException
     */
    public function __construct() {
        if (!($redisConnection = getenv('MINIMALISM_SERVICE_REDIS_CONNECTION')) !== false) {
            throw new configurationException('redis', 'MINIMALISM_SERVICE_REDIS_CONNECTION is a required configuration');
        }

        [
            $this->host,
            $this->port,
            $this->password,
        ] = explode(',', $redisConnection);
    }
}