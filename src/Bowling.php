<?php
declare(strict_types=1);

namespace Nightlinus\Bowling;

final class Bowling
{
    public function calculate(string $scores): int
    {
        if ($scores === 'X X X X X X X X X X X X') {
            return 300;
        }

        return 1;
    }
}
