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

    /* Более длинный, но более понятный способ подсчета */
    public function calculate_like_a_pro(string $scores): int
    {
        $scores = str_replace('-', '0', $scores);
        $frames = explode(' ', $scores);
        $balls = [];
        foreach ($frames as $i => $frame) {
            [ $first, $strike ] = $this->firstBall($frame[ 0 ], $i);
            $balls[] = Ball::from($first, $i + 1, $strike, false);
            if (isset($frame[ 1 ])) {
                [ $second, $spare ] = $this->secondBall($frame[ 1 ], $first, $i);
                $balls[] = Ball::from($second, $i + 1, false, $spare);
            }
        }

        $total = 0;
        /** @var $balls Ball[] */
        foreach ($balls as $i => $ball) {
            if ($ball->frame() <= 10) {
                $total += $ball->score();
            }
            if ($ball->isSpare()) {
                $next = $balls[ $i + 1 ]->score() ?? 0;
                $total += $next;
            }
            if ($ball->isStrike()) {
                $next = $balls[ $i + 1 ]->score() ?? 0;
                $nextnext = $balls[ $i + 2 ]->score() ?? 0;
                $total += $next + $nextnext;
            }

            $total += 0;
        }

        return $total;
    }

    private function firstBall(string $score, int $i): array
    {
        if ($score === 'X') {
            return [ 10, $i < 10 ];
        }

        return [ (int) $score, false ];
    }

    private function secondBall(string $score, int $first, int $i): array
    {
        if ($score === '/') {
            return [ 10 - $first, $i < 10 ];
        }

        return [ (int) $score, false ];
    }
}
