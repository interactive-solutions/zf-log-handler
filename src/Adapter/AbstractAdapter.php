<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\LogHandler\Adapter;

abstract class AbstractAdapter implements AdapterInterface
{
    abstract public function write(array $data, string $type = null): bool;
}
