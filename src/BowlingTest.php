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
    public function it_calculates_scores_for_10_strike_game()
    {
        $this->assertScoresEquals('X X X X X X X X X X - -', 270);
    }

    /** @test */
    public function it_calculates_scores_for_9_strike_and_5_game()
    {
        $this->assertScoresEquals('X X X X X 5- X X X X - -', 225);
    }

    /** @test */
    public function it_calculates_scores_for_one_bowl()
    {
        $this->assertScoresEquals('1- -- -- -- -- -- -- -- -- --', 1);
    }

    /** @test */
    public function it_calculates_score_for_all_nine_point_frames()
    {
        $this->assertScoresEquals('9- 9- 9- 9- 9- 9- 9- 9- 9- 9-', 90);
    }

    /** @test */
    public function it_calculates_score_with_spares()
    {
        $this->assertScoresEquals('5/ 5/ 5/ 5/ 5/ 5/ 5/ 5/ 5/ 5/ 5', 150);
    }

    /** @test */
    public function it_calculates_random_score()
    {
        $this->assertScoresEquals('1- -- -- -- X 52 -- -- -- --', 25);
    }

    /** @test */
    public function it_calculates_more_random_score()
    {
        $this->assertScoresEquals('X 5/ 5/ 5/ 52 5/ 5/ 5/ 7- 5/ 5', 141);
    }

    private function assertScoresEquals(string $game, int $expected)
    {
        $bowling = new Bowling();
        $score = $bowling->calculate($game);

        $this->assertEquals($expected, $score);
    }
}
