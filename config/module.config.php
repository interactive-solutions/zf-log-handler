<?php

use Elastica\Client;
use InteractiveSolutions\ErrorHandler\Adapter\ElasticsearchAdapter;
use InteractiveSolutions\ErrorHandler\Factory\Adapter\ElasticsearchAdapterFactory;
use InteractiveSolutions\ErrorHandler\Factory\Client\ElasticaClientFactory;
use InteractiveSolutions\ErrorHandler\Factory\Service\ErrorHandlerServiceFactory;
use InteractiveSolutions\ErrorHandler\Service\ErrorHandlerService;

return [
    'service_manager' => [
        'factories' => [
            ElasticsearchAdapter::class => ElasticsearchAdapterFactory::class,
            ErrorHandlerService::class => ErrorHandlerServiceFactory::class,

            Client::class => ElasticaClientFactory::class
        ],
    ],
];
