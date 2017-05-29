<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types = 1);

namespace InteractiveSolutions\ErrorHandler;

use InteractiveSolutions\ErrorHandler\Adapter\ElasticsearchAdapter;
use InteractiveSolutions\ErrorHandler\Service\ErrorHandlerInterface;
use InteractiveSolutions\ErrorHandler\Service\ErrorHandlerService;
use Zend\Loader\StandardAutoloader;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\Application;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface
{
    /**
     * @inheritDoc
     */
    public function getAutoloaderConfig(): array
    {
        return [
            StandardAutoloader::class => [
                StandardAutoloader::LOAD_NS => [
                    __NAMESPACE__ => __DIR__ . '/src'
                ],
            ],
        ];
    }

    public function onBootstrap(MvcEvent $e)
    {
        $sharedManager = $e->getApplication()->getEventManager()->getSharedManager();
        $sm            = $e->getApplication()->getServiceManager();
        $sharedManager->attach(Application::class, MvcEvent::EVENT_DISPATCH_ERROR,
            function($e) use ($sm) {
            /** @var MvcEvent $e */
                $exception = $e->getError();
                /** @var ErrorHandlerInterface $errorReportingService */
                $errorReportingService = $sm->get(ErrorHandlerService::class);
//                $errorReportingService->handleException($exception);
            }, 1000
        );
    }

    /**
     * @inheritDoc
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
