<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\ZfLogHandler\Factory\Client;

use Elastica\Client;
use InteractiveSolutions\ZfLogHandler\Options\ElasticsearchOptions;
use Interop\Container\ContainerInterface;

final class ElasticaClientFactory
{
    /**
     * @param ContainerInterface $container
     * @return Client
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function __invoke(ContainerInterface $container): Client
    {
        /* @var ElasticsearchOptions $options */
        $options = $container->get(ElasticsearchOptions::class);

        return new Client([
            'host'     => $options->getHost(),
            'port'     => $options->getPort(),
            'username' => $options->getUsername(),
            'password' => $options->getPassword(),
            'timeout'  => 1,
        ]);
    }
}
