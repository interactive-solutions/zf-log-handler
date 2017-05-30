<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types=1);

namespace InteractiveSolutions\LogHandler\Factory\Options;

use InteractiveSolutions\LogHandler\Options\ElasticsearchOptions;
use Psr\Container\ContainerInterface;

final class ElasticsearchOptionsFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return ElasticsearchOptions
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ElasticsearchOptions
    {
        $config = $container->get('Config')['interactive_solutions']['options'];
        $config = $config[ElasticsearchOptions::class] ?? [];

        return new ElasticsearchOptions($config);
    }
}
