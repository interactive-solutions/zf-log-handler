<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types=1);

namespace InteractiveSolutions\ZfLogHandler\Factory\Listener;

use InteractiveSolutions\ZfLogHandler\Listener\ErrorListener;
use InteractiveSolutions\ZfLogHandler\Service\LogHandlerService;
use Psr\Container\ContainerInterface;

final class ErrorListenerFactory
{
    /**
     * @param ContainerInterface $container
     * @return ErrorListener
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ErrorListener
    {
        return new ErrorListener($container->get(LogHandlerService::class));
    }
}
