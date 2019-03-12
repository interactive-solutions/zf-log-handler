<?php

use Elastica\Client;
use InteractiveSolutions\ZfLogHandler\Adapter\ElasticsearchAdapter;
use InteractiveSolutions\ZfLogHandler\Factory\Adapter\ElasticsearchAdapterFactory;
use InteractiveSolutions\ZfLogHandler\Factory\Client\ElasticaClientFactory;
use InteractiveSolutions\ZfLogHandler\Factory\Listener\RequestResponseDataListenerFactory;
use InteractiveSolutions\ZfLogHandler\Factory\Options\ElasticsearchOptionsFactory;
use InteractiveSolutions\ZfLogHandler\Factory\Options\LogHandlerOptionsFactory;
use InteractiveSolutions\ZfLogHandler\Factory\Service\LogHandlerServiceFactory;
use InteractiveSolutions\ZfLogHandler\Listener\RequestResponseDataListener;
use InteractiveSolutions\ZfLogHandler\Options\ElasticsearchOptions;
use InteractiveSolutions\ZfLogHandler\Options\LogHandlerOptions;
use InteractiveSolutions\ZfLogHandler\Service\LogHandlerService;

return [
    'service_manager' => [
        'factories' => [
            RequestResponseDataListener::class => RequestResponseDataListenerFactory::class,

            ElasticsearchAdapter::class => ElasticsearchAdapterFactory::class,

            LogHandlerService::class => LogHandlerServiceFactory::class,

            Client::class => ElasticaClientFactory::class,

            LogHandlerOptions::class    => LogHandlerOptionsFactory::class,
            ElasticsearchOptions::class => ElasticsearchOptionsFactory::class,
        ],
    ],
];
