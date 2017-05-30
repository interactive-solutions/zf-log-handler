<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\ZfLogHandler\Service;

use Throwable;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Router\RouteMatch;

interface LogHandlerServiceInterface
{
    /**
     * Handle and log exceptions
     *
     * @param Throwable $exception
     */
    public function handleException(Throwable $exception);

    /**
     * Handle and log request/response details
     *
     * @param Request $request
     * @param Response $response
     * @param RouteMatch|null $routeMatch
     */
    public function handleRequestResponse(Request $request, Response $response, RouteMatch $routeMatch = null);

    /**
     * Returns a list of active adapters
     *
     * @return array
     */
    public function getAdapters(): array;
}
