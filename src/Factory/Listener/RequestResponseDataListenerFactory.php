<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types=1);

namespace InteractiveSolutions\LogHandler\Factory\Listener;

use InteractiveSolutions\LogHandler\Listener\RequestResponseDataListener;
use InteractiveSolutions\LogHandler\Options\LogHandlerOptions;
use Psr\Container\ContainerInterface;

final class RequestResponseDataListenerFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @return RequestResponseDataListener
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function __invoke(ContainerInterface $container): RequestResponseDataListener
    {
        return new RequestResponseDataListener($container->get(LogHandlerOptions::class));
    }
}
