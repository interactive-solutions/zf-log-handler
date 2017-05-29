<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\ErrorHandler\Factory\Service;

use InteractiveSolutions\ErrorHandler\Service\ErrorHandlerService;
use Interop\Container\ContainerInterface;

final class ErrorHandlerServiceFactory
{
    public function __invoke(ContainerInterface $container): ErrorHandlerService
    {
        return new ErrorHandlerService();
    }
}
