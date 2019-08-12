<?php
declare(strict_types=1);

namespace Nightlinus\Bowling;

final class Bowling
{
    public function calculate(string $scores): int
    {
        $currentScore = 0;
        $frameNumber = 0;
        $wasStrike = false;
        $twoStrikes = false;
        $wasSpare = false;

        $breakingScores = explode(' ', $scores);

        foreach ($breakingScores as $frame) {
            $frameNumber++;
            if ($frameNumber === 11) {
                $frame = str_replace([ 'X', '-' ], [ 10, 0 ], $frame);
                $currentScore += $frame;
                if ($twoStrikes) {
                    $currentScore += $frame;
                }
                continue;
            }
            if ($frameNumber === 12) {
                $frame = str_replace([ 'X', '-' ], [ 10, 0 ], $frame);
                $currentScore += $frame;
                continue;
            }
            $strike = $frame === 'X';
            if ($strike) {
                $currentScore += 10;
                if ($twoStrikes) {
                    $currentScore += 10;
                }
                if ($wasStrike) {
                    $currentScore += 10;
                    $twoStrikes = true;
                }
                if ($wasSpare) {
                    $currentScore += 10;
                }
                $wasStrike = true;
                continue;
            }
            $frame = str_replace('-', 0, $frame);
            $firstFrame = $frame[ 0 ];
            $secondFrame = $frame[ 1 ] ?? 0;
            $spare = $secondFrame === '/';
            if ($spare) {
                $currentScore += 10;
                if ($wasStrike) {
                    $currentScore += 10;
                }
                if ($twoStrikes) {
                    $currentScore += 10;
                }
                if ($wasSpare) {
                    $currentScore += $firstFrame;
                }
                $wasSpare = true;
                $wasStrike = false;
                $twoStrikes = false;
                continue;
            }

            $currentScore += $firstFrame;
            $currentScore += $secondFrame;
            if ($wasStrike) {
                $currentScore += $firstFrame + $secondFrame;
            }
            if ($twoStrikes) {
                $currentScore += $firstFrame;
            }
            if ($wasSpare) {
                $currentScore += $firstFrame;
            }
            $wasSpare = false;
            $wasStrike = false;
            $twoStrikes = false;

        }

        return $currentScore;
    }
}
