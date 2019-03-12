<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\ZfLogHandler\Service;

use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Router\RouteMatch;

interface LogHandlerServiceInterface
{
    /**
     * Handle and log request/response details
     *
     * @param Request $request
     * @param Response $response
     * @param RouteMatch|null $routeMatch
     * @param float|null $duration
     * @param array $context
     * @return
     */
    public function handleRequestResponse(
        Request $request,
        Response $response,
        RouteMatch $routeMatch = null,
        float $duration = null,
        array $context = []
    );

    /**
     * Returns a list of active adapters
     *
     * @return array
     */
    public function getAdapters(): array;
}
