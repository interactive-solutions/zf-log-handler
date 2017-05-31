# zf-log-handler
Utility library to log exception (with stacktrace) and requests/response details
to configured adapters.

## Request duration
The duration will be part of the data sent to each adapter if the constant `START_TIME` is
defined. If you wish to log the duration you should `define('START_TIME', microtime(true))`
before the application is bootstrapped.

## Adapters
All adapters must implement the `AdapterInterface`, the only provided adapter built into 
this library is `ElasticsearchAdapter` which logs data to elasticsearch.

## Options

### `LogHandlerOptions`
Handles general configuration of this library.

Example config below:
```php
LogHandlerOptions::class => [
    'environment'     => 'dev',
    'debug'           => true,
    'adapters'        => [
        ElasticsearchAdapter::class,
    ],
    'alwaysLogRoutes' => [],
],
```

- `environment` is a string that will be added to the data array being logged, useful for
easy filtering if logs contains data from several environments
- `debug` if set to true will log each incoming request and its corresponding response,
if set to false it will disable logging of requests/responses
- `adapters` list of adapters implementing the `AdapterInterface`, each adapter's `write`
method with all data to be logged
- `alwaysLogRoutes` list of route names whose request and corresponding response
that should *always* be logged (event if `debug` is set to false)

### `ElasticsearchOptions`
Handles configuration for the `ElasticsearchAdapter`.

Example config below:
```php
ElasticsearchOptions::class => [
    'host'     => 'localhost,
    'port'     => <port>,
    'username' => '',
    'password' => '',
    'prefix'   => 'project-name',
],
```

- `host` the elasticsearch host
- `port` port of the elasticsearch host
- `username` username to log onto elasticsearch
- `password` password to log onto elasticsearch
- `prefix` the prefix of the index in elasticsearch where data should be logged
