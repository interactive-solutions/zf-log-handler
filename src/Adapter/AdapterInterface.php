<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\ZfLogHandler\Adapter;

interface AdapterInterface
{
    /**
     * Write data to adapter
     *
     * @param array $data
     * @param string $type
     * @return bool
     */
    public function write(array $data, string $type = 'requests'): bool;
}
