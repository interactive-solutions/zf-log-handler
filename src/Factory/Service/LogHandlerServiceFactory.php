<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\ZfLogHandler\Factory\Service;

use InteractiveSolutions\ZfLogHandler\Options\LogHandlerOptions;
use InteractiveSolutions\ZfLogHandler\Service\LogHandlerService;
use Interop\Container\ContainerInterface;

final class LogHandlerServiceFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return LogHandlerService
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function __invoke(ContainerInterface $container): LogHandlerService
    {
        /* @var LogHandlerOptions $options */
        $options  = $container->get(LogHandlerOptions::class);
        $adapters = array_map(function (string $adapter) use ($container) {
            return $container->get($adapter);
        }, $options->getAdapters());

        return new LogHandlerService($options, $adapters);
    }
}
