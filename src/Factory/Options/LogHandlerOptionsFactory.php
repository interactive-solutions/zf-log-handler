<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types=1);

namespace InteractiveSolutions\LogHandler\Factory\Options;

use InteractiveSolutions\LogHandler\Options\LogHandlerOptions;
use Psr\Container\ContainerInterface;

final class LogHandlerOptionsFactory
{
    /**
     * @param ContainerInterface $container
     * @return LogHandlerOptions
     */
    public function __invoke(ContainerInterface $container): LogHandlerOptions
    {
        $config = $container->get('Config')['interactive_solutions']['options'];
        $config = $config[LogHandlerOptions::class] ?? [];

        return new LogHandlerOptions($config);
    }
}
