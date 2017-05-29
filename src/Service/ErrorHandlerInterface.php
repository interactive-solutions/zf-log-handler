<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\ErrorHandler\Service;


use Throwable;

interface ErrorHandlerInterface
{
    public function handleException(Throwable $exception);

    /**
     * Returns a list of active adapters
     *
     * @return array
     */
    public function getAdapters(): array;
}
