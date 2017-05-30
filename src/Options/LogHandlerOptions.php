<?php
/**
 * @author Erik Norgren <erik.norgren@interactivesolutions.se>
 * @copyright Interactive Solutions
 */

declare(strict_types=1);

namespace InteractiveSolutions\ZfLogHandler\Options;

use Zend\Stdlib\AbstractOptions;

final class LogHandlerOptions extends AbstractOptions
{
    /**
     * @var bool
     */
    protected $debug = false;

    /**
     * @var array
     */
    protected $alwaysLogRoutes = [];

    /**
     * @var array
     */
    protected $adapters = [];

    /**
     * @var string
     */
    protected $environment = 'dev';

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     */
    public function setDebug(bool $debug)
    {
        $this->debug = $debug;
    }

    /**
     * @return array
     */
    public function getAlwaysLogRoutes(): array
    {
        return $this->alwaysLogRoutes;
    }

    /**
     * @param array $alwaysLogRoutes
     */
    public function setAlwaysLogRoutes(array $alwaysLogRoutes)
    {
        $this->alwaysLogRoutes = $alwaysLogRoutes;
    }

    /**
     * @return array
     */
    public function getAdapters(): array
    {
        return $this->adapters;
    }

    /**
     * @param mixed $adapters
     */
    public function setAdapters($adapters)
    {
        $this->adapters = $adapters;
    }

    /**
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @param string $environment
     */
    public function setEnvironment(string $environment)
    {
        $this->environment = $environment;
    }
}
