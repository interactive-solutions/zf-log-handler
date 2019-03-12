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
    public function handleRequestResponse(
        Request $request,
        Response $response,
        RouteMatch $routeMatch = null,
        float $duration = null,
        array $context = []
    ) {
        if ($this->options->isDebug() || $this->isAlwaysLogRoute($routeMatch)) {
            $data = [
                '@timestamp'  => date(DATE_RFC3339),
                'host'        => $this->options->getHost(),
                'environment' => $this->options->getEnvironment(),
                'duration'    => $duration ?? 0.0,
                'request'     => [
                    'headers'    => $request->getHeaders()->toString(),
                    'routeMatch' => $routeMatch ? $routeMatch->getMatchedRouteName() : '',
                    'url'        => $request->getUriString(),
                    'body'       => $this->blurKeywords($request->getContent()),
                    'query'      => $this->blurKeywords($request->getQuery()->toString()),
                    'method'     => $request->getMethod(),
                ],
                'response'    => [
                    'headers'    => $response->getHeaders()->toString(),
                    'body'       => $response->getContent(),
                    'statusCode' => $response->getStatusCode(),
                ],
                'context' => json_encode($context)
            ];

           $this->writeData($data);
        }
    }

    /**
     * Write the data to adapters
     *
     * @param array $data
     * @param string $type
     */
    private function writeData(array $data, string $type = 'requests')
    {
        /* @var AbstractAdapter $adapter */
        foreach ($this->adapters as $adapter) {
            try {
                $adapter->write($data, $type);
            } catch (Exception $e) {
                // To prevent application from crashing
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
     * Check if string contains keys that should be blurred out
     * This will only check top-level
     *
     * @param string $body
     * @return string
     */
    private function blurKeywords(string $body): string
    {
        try {
            $isJson = true;
            $bodyAsArray = Json::decode($body, true);
        } catch (RuntimeException $e) {
            $isJson = false;
            parse_str($body, $bodyAsArray);
        }

        if (!is_array($bodyAsArray)) {
            return $body;
        }

        foreach ($bodyAsArray as $key => $value) {
            if (in_array($key, $this->options->getBlurredKeys(), false)) {
                $bodyAsArray[$key] = $this->options->getBlurredKeysValue();
            }
        }

        if ($isJson) {
            return Json::encode($bodyAsArray);
        }

        return http_build_query($bodyAsArray);
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
}
