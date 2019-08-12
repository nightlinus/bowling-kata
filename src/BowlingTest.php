<?php
declare(strict_types=1);

namespace Nightlinus\Bowling;

use PHPUnit\Framework\TestCase;

class BowlingTest extends TestCase
{
    /** @test */
    public function it_calculates_scores_for_12_strike_game()
    {
        $this->assertScoresEquals('X X X X X X X X X X X X', 300);
    }

    /** @test */
    public function it_calculates_scores()
    {
        $this->assertScoresEquals('1- -- -- -- -- -- -- -- -- --', 1);
    }

    private function assertScoresEquals(string $game, int $expected)
    {
        $bowling = new Bowling();
        $score = $bowling->calculate($game);

        $this->assertEquals($expected, $score);
    }
}
