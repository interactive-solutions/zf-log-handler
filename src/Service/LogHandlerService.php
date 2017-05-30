<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\LogHandler\Service;

use InteractiveSolutions\LogHandler\Adapter\AbstractAdapter;
use InteractiveSolutions\LogHandler\Options\LogHandlerOptions;
use Throwable;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Router\RouteMatch;

final class LogHandlerService implements LogHandlerServiceInterface
{
    /**
     * @var LogHandlerOptions
     */
    private $options;

    /**
     * LogHandlerService constructor.
     * @param LogHandlerOptions $options
     */
    public function __construct(LogHandlerOptions $options)
    {
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function handleException(Throwable $exception)
    {
        if ($exception instanceof Throwable) {
            $data = [
                '@timestamp' => date(DATE_RFC3339),
                'message'    => $exception->getMessage(),
                'class'      => get_class($exception),
                'stacktrace' => $exception->getTraceAsString(),
            ];

            $this->recurseException($data, $exception->getPrevious());
        } else {
            $data = [
                '@timestamp' => date(DATE_RFC3339),
                'message'    => 'None exception error occurred',
                'class'      => get_class($exception),
                'payload'    => $exception,
            ];
        }

        /* @var AbstractAdapter $adapter */
        foreach ($this->options->getAdapters() as $adapter) {
            $adapter->write($data, 'errors');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequestResponse(Request $request, Response $response, RouteMatch $routeMatch = null)
    {
        if ($this->options->isDebug() || $this->isAlwaysLogRoute($routeMatch)) {
            $data = [
                'request'  => [
                    'headers' => $request->getHeaders()->toArray(),
                    'url'     => $request->getUriString(),
                    'body'    => $request->getContent(),
                    'query'   => $request->getQuery()->toArray(),
                ],
                'response' => [
                    'headers'    => $response->getHeaders()->toArray(),
                    'body'       => $response->getContent(),
                    'statusCode' => $response->getStatusCode(),
                ],
            ];

            /* @var AbstractAdapter $adapter */
            foreach ($this->options->getAdapters() as $adapter) {
                $adapter->write($data, 'http-access-log');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAdapters(): array
    {
        return $this->options->getAdapters();
    }

    /**
     * Check if matched route should always be logged for http request/response
     *
     * @param RouteMatch|null $routeMatch
     * @return bool
     */
    private function isAlwaysLogRoute(RouteMatch $routeMatch = null): bool
    {
        return $routeMatch && in_array($routeMatch->getMatchedRouteName(), $this->options->getAlwaysLogRoutes(), true);
    }

    /**
     * @param $data
     * @param Throwable|null $exception
     */
    private function recurseException(&$data, Throwable $exception = null)
    {
        if ($exception === null) {
            return;
        }

        $data['previous'] = [
            'class'      => get_class($exception),
            'message'    => $exception->getMessage(),
            'stacktrace' => $exception->getTraceAsString(),
        ];

        $this->recurseException($data['previous'], $exception->getPrevious());
    }
}
