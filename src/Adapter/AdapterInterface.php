<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\LogHandler\Adapter;

interface AdapterInterface
{
    /**
     * Write data to adapter
     *
     * @param array $data
     * @param string|null $type
     * @return bool
     */
    public function write(array $data, string $type = null): bool;
}
