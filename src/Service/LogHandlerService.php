<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\ZfLogHandler\Service;

use InteractiveSolutions\ZfLogHandler\Adapter\AbstractAdapter;
use InteractiveSolutions\ZfLogHandler\Options\LogHandlerOptions;
use Throwable;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Json\Exception\RuntimeException;
use Zend\Json\Json;
use Zend\Mvc\Router\RouteMatch;
use Exception;

final class LogHandlerService implements LogHandlerServiceInterface
{
    /**
     * @var array
     */
    private $adapters = [];

    /**
     * @var LogHandlerOptions
     */
    private $options;

    /**
     * LogHandlerService constructor.
     * @param LogHandlerOptions $options
     * @param array $adapters
     */
    public function __construct(LogHandlerOptions $options, array $adapters)
    {
        $this->options  = $options;
        $this->adapters = $adapters;
    }

    /**
     * {@inheritdoc}
     */
    public function handleException(Throwable $exception)
    {
        if ($exception instanceof Throwable) {
            $data = [
                'environment' => $this->options->getEnvironment(),
                '@timestamp'  => date(DATE_RFC3339),
                'message'     => $exception->getMessage(),
                'class'       => get_class($exception),
                'stacktrace'  => $exception->getTraceAsString(),
            ];

            $this->recurseException($data, $exception->getPrevious());
        } else {
            $data = [
                'environment' => $this->options->getEnvironment(),
                '@timestamp'  => date(DATE_RFC3339),
                'message'     => 'None exception error occurred',
                'class'       => get_class($exception),
                'payload'     => $exception,
            ];
        }

        /* @var AbstractAdapter $adapter */
        foreach ($this->getAdapters() as $adapter) {
            try {
                $adapter->write($data, 'errors');
            } catch (Exception $e) {
                // Prevent application from crashing
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequestResponse(Request $request, Response $response, RouteMatch $routeMatch = null)
    {
        if ($this->options->isDebug() || $this->isAlwaysLogRoute($routeMatch)) {
            $data = [
                'environment' => $this->options->getEnvironment(),
                'request'     => [
                    'headers' => $request->getHeaders()->toArray(),
                    'url'     => $request->getUriString(),
                    'body'    => $request->getContent(),
                    'json'    => $this->getJsonFromBody($request->getContent()),
                    'query'   => $request->getQuery()->toArray(),
                ],
                'response'    => [
                    'headers'    => $response->getHeaders()->toArray(),
                    'body'       => $response->getContent(),
                    'json'       => $this->getJsonFromBody($response->getContent()),
                    'statusCode' => $response->getStatusCode(),
                ],
            ];

            /* @var AbstractAdapter $adapter */
            foreach ($this->adapters as $adapter) {
                try {
                    $adapter->write($data, 'http-access-log');
                } catch (Exception $e) {
                    // To prevent application from crashing
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAdapters(): array
    {
        return $this->adapters;
    }

    /**
     * Json decode a string if possible
     *
     * This cannot be typed if a body is a single digit
     *
     * @param mixed $body
     * @return array|mixed
     */
    private function getJsonFromBody($body)
    {
        try {
            return Json::decode($body, Json::TYPE_ARRAY);
        } catch (RuntimeException $e) {
            return [];
        }
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
