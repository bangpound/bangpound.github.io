---
title: Guzzle 6 Logging with Symfony: what's the right way to create a callback service?
categories:
    - PHP
tags:
    - PHP
    - Guzzle
    - Symfony

---

The [latest version of Guzzle](https://github.com/guzzle/guzzle/releases/tag/6.0.0) uses PSR-7. Functionality that
previously was based on events is now implemented as middleware. The [log subscriber](https://github.com/guzzle/log-subscriber)
is not supported, and the logging middleware is part of the main Guzzle package.

This is how I implemented a Guzzle service with logging with Symfony's container.

```yaml
parameters:
    guzzle.class: GuzzleHttp\Client
    guzzle.stack.class: GuzzleHttp\HandlerStack
    guzzle.middleware.class: GuzzleHttp\Middleware
    guzzle.message_formatter.class: GuzzleHttp\MessageFormatter

services:
    guzzle:
        class: %guzzle.class%
        arguments:
            -
                handler: @guzzle.stack

    guzzle.stack:
        public: false
        class: %guzzle.stack.class%
        factory: [ %guzzle.stack.class%, create ]
        calls:
            - [ push, [ @guzzle.logger ] ]

    guzzle.message_formatter:
        public: false
        class: %guzzle.message_formatter.class%

    guzzle.logger:
        public: false
        class: callback
        arguments: [@logger, @guzzle.message_formatter]
        factory: [GuzzleHttp\Middleware, log]
```

On the `guzzle.logger` service, the `callback` class is actually invalid, but without a class, it complains:

> [Symfony\Component\DependencyInjection\Exception\RuntimeException] Please add the class to service "guzzle.logger" even if it is constructed by a factory since we might need to add method calls based on compile-time checks.

Nonetheless, when the dependencies are not public, Symfony compiles the Guzzle client service with a logger correctly.

```php
<?php

use Symfony\Component\DependencyInjection\Container;

class appDevDebugProjectContainer extends Container
{
    protected function getGuzzleService()
    {
        $a = \GuzzleHttp\HandlerStack::create();
        $a->push(\GuzzleHttp\Middleware::log(
            $this->get('logger'),
            new \GuzzleHttp\MessageFormatter()
        ));

        return $this->services['guzzle'] = new \GuzzleHttp\Client(array(
            'handler' => $a
        ));
    }
}
```

Given that Symfony services must be objects with classes, what is the right way to create a service with callbacks
without using a factory? The trick is to create the service without a factory, because if the service is
constructed entirely within the container, it could be configured or extended with container extensions and compiler
passes.
