<?php

use Elastica\Client;
use InteractiveSolutions\LogHandler\Adapter\ElasticsearchAdapter;
use InteractiveSolutions\LogHandler\Factory\Adapter\ElasticsearchAdapterFactory;
use InteractiveSolutions\LogHandler\Factory\Client\ElasticaClientFactory;
use InteractiveSolutions\LogHandler\Factory\Listener\RequestResponseDataListenerFactory;
use InteractiveSolutions\LogHandler\Factory\Options\ElasticsearchOptionsFactory;
use InteractiveSolutions\LogHandler\Factory\Options\LogHandlerOptionsFactory;
use InteractiveSolutions\LogHandler\Factory\Service\LogHandlerServiceFactory;
use InteractiveSolutions\LogHandler\Listener\RequestResponseDataListener;
use InteractiveSolutions\LogHandler\Options\ElasticsearchOptions;
use InteractiveSolutions\LogHandler\Options\LogHandlerOptions;
use InteractiveSolutions\LogHandler\Service\LogHandlerService;

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
