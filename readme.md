# minimalism-service-redis

**encrypter** is a service for [minimalism](https://github.com/carlonicora/minimalism) to generate short unique ids from
integers.

## Getting Started

To use this library, you need to have an application using minimalism. This library does not work outside this scope.

### Prerequisite

You should have read the [minimalism documentation](https://github.com/carlonicora/minimalism/readme.md) and understand
the concepts of services in the framework.

minimalism-service-redis requires the [redis](https://pecl.php.net/package/redis) extension in order to work.


### Installing

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```
$ composer require carlonicora/minimalism-service-redis
```

or simply add the requirement in `composer.json`

```json
{
    "require": {
        "carlonicora/minimalism-service-redis": "~1.0"
    }
}
```

## Deployment

This service requires you to set up a parameter in your `.env` file in order to connect to redis

### Required parameters

```dotenv
#a comma separated list  
MINIMALISM_SERVICE_REDIS_CONNECTION=host,port,password  
```

## Build With

* [minimalism](https://github.com/carlonicora/minimalism) - minimal modular PHP MVC framework

## Versioning

This project use [Semantiv Versioning](https://semver.org/) for its tags.

## Authors

* **Carlo Nicora** - Initial version - [GitHub](https://github.com/carlonicora) |
[phlow](https://phlow.com/@carlo)

# License

This project is licensed under the [MIT license](https://opensource.org/licenses/MIT) - see the
[LICENSE.md](LICENSE.md) file for details 

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)