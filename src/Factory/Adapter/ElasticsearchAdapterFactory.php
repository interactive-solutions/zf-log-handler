<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\LogHandler\Factory\Adapter;

use Elastica\Client;
use InteractiveSolutions\LogHandler\Adapter\ElasticsearchAdapter;
use Interop\Container\ContainerInterface;

final class ElasticsearchAdapterFactory
{
    public function __invoke(ContainerInterface $container): ElasticsearchAdapter
    {
        /* @var Client $elasticaClient */
        $elasticaClient = $container->get(Client::class);

        return new ElasticsearchAdapter($elasticaClient);
    }
}
