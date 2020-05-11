<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use SeeNotEvil\RankingSport\Sort\SportRankingSort;

class SortSportRankingTest extends TestCase
{
    /**
     * @var SportRankingSort
     */
    private $sortSportRanking;

    public function setUp(): void
    {
        $this->sortSportRanking = new SportRankingSort();
    }

    public function testSort()
    {
        $teams = [
            ["team" => "team1", "scores" => 44],
            ["team" => "team4", "scores" => 22],
            ["team" => "team2", "scores" => 44],
            ["team" => "team3", "scores" => 88],
        ];

        $expected = [
            ["rank" => 1, "team" => "team3", "scores" => 88],
            ["rank" => 2, "team" => "team1", "scores" => 44],
            ["rank" => 2, "team" => "team2", "scores" => 44],
            ["rank" => 4, "team" => "team4", "scores" => 22],
        ];

        $actual = ($this->sortSportRanking)($teams);
        $this->assertEquals($expected, $actual);
    }
}