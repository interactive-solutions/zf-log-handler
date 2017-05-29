<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\ErrorHandler\Service;

use InteractiveSolutions\ErrorHandler\Adapter\AbstractAdapter;
use InteractiveSolutions\ErrorHandler\Adapter\BlackHoleAdapter;
use InteractiveSolutions\ErrorHandler\Adapter\ElasticsearchAdapter;
use Throwable;

final class ErrorHandlerService implements ErrorHandlerInterface
{
    protected $adapters = [
        BlackHoleAdapter::class
    ];

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

        /** @var AbstractAdapter $adapter */
        foreach ($this->getAdapters() as $adapter) {
            $adapter->write($data);
        }
    }

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

    public function getAdapters(): array
    {
        return $this->adapters;
    }
}
