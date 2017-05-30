<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types=1);

namespace InteractiveSolutions\LogHandler\Listener;

use InteractiveSolutions\LogHandler\Service\LogHandlerServiceInterface;
use Throwable;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;

final class ErrorListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /**
     * @var LogHandlerServiceInterface
     */
    private $service;

    /**
     * LogRequestResponseDataListener constructor.
     * @param LogHandlerServiceInterface $service
     */
    public function __construct(LogHandlerServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR, [$this, 'handleErrorData'], 1000);
    }

    /**
     * Call log handler service with request/response and matched route
     *
     * @param MvcEvent $event
     */
    public function handleErrorData(MvcEvent $event)
    {
        if ($event->getParam('exception') instanceof Throwable) {
            $this->service->handleException($event->getParam('exception'));
        }
    }
}
