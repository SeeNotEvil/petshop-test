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
            ["team" => "team1", "score" => 44],
            ["team" => "team2", "score" => 44],
            ["team" => "team3", "score" => 88],
        ];

        $expected = [
            ["rank" => 1, "team" => "team1", "score" => 44],
            ["rank" => 1, "team" => "team2", "score" => 44],
            ["rank" => 3, "team" => "team3", "score" => 88],
        ];

        $actual = ($this->sortSportRanking)($teams);
        $this->assertEquals($expected, $actual);
    }
}