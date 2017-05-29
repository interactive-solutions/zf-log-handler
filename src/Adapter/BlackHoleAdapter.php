<?php
/**
 * @author    Jonas Eriksson <jonas.eriksson@interactivesolutions.se>
 *
 * @copyright Interactive Solutions
 */
declare(strict_types=1);

namespace InteractiveSolutions\ErrorHandler\Adapter;

final class BlackHoleAdapter extends AbstractAdapter
{
    public function write(array $data): bool
    {
        return true;
    }
}
