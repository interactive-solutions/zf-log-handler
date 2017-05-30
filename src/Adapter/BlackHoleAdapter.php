<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\LogHandler\Adapter;

final class BlackHoleAdapter extends AbstractAdapter
{
    public function write(array $data, string $type = null): bool
    {
        return true;
    }
}
