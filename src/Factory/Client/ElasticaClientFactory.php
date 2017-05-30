<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\LogHandler\Factory\Client;

use Elastica\Client;
use Interop\Container\ContainerInterface;

final class ElasticaClientFactory
{
    public function __invoke(ContainerInterface $container): Client
    {
        return new Client([
            'host' => '10.91.51.24',
            'username' => '',
            'password' => ''
        ]);
    }
}
