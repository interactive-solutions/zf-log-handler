<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\ZfLogHandler\Factory\Adapter;

use Elastica\Client;
use InteractiveSolutions\ZfLogHandler\Adapter\ElasticsearchAdapter;
use InteractiveSolutions\ZfLogHandler\Options\ElasticsearchOptions;
use Interop\Container\ContainerInterface;

final class ElasticsearchAdapterFactory
{
    /**
     * @param ContainerInterface $container
     * @return ElasticsearchAdapter
     */
    public function __invoke(ContainerInterface $container): ElasticsearchAdapter
    {
        /* @var Client $elasticaClient */
        $elasticaClient = $container->get(Client::class);

        return new ElasticsearchAdapter($elasticaClient);
    }
}
