<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */

namespace InteractiveSolutions\ErrorHandler\Adapter;

interface AdapterInterface
{
    public function write(array $data): bool;
}
