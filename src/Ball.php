<?php
declare(strict_types=1);

namespace Nightlinus\Bowling;

final class Ball
{
    /** @var int */
    private $score;

    /** @var int */
    private $frame;

    /** @var bool */
    private $strike;

    /** @var bool */
    private $spare;

    public function __construct(int $score, int $frame, bool $strike, bool $spare)
    {
        $this->score = $score;
        $this->frame = $frame;
        $this->strike = $strike;
        $this->spare = $spare;
    }

    public static function from(int $score, int $frame, bool $strike, bool $spare): self
    {
        return new self($score, $frame, $strike, $spare);
    }

    public function score(): int
    {
        return $this->score;
    }

    public function isStrike(): bool
    {
        return $this->strike;
    }

    public function isSpare(): bool
    {
        return $this->spare;
    }

    public function frame(): int
    {
        return $this->frame;
    }
}
