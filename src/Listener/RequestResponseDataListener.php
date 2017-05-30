<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types=1);

namespace InteractiveSolutions\ZfLogHandler\Listener;

use InteractiveSolutions\ZfLogHandler\Options\LogHandlerOptions;
use InteractiveSolutions\ZfLogHandler\Service\LogHandlerServiceInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;

final class RequestResponseDataListener implements ListenerAggregateInterface
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
        $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, [$this, 'handleRequestResponseData'], 1000);
    }

    /**
     * Call log handler service with request/response and matched route
     *
     * @param MvcEvent $event
     */
    public function handleRequestResponseData(MvcEvent $event)
    {
        /* @var Request $request */
        $request = $event->getRequest();
        /* @var Response $response */
        $response = $event->getResponse();

        $routeMatch = $event->getRouteMatch();
        
        $this->service->handleRequestResponse($request, $response, $routeMatch);
    }
}
