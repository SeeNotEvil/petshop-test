<?php

namespace SeeNotEvil\RankingSport\Sort;

use SeeNotEvil\RankingSport\RankingSortInterface;

class SportRankingSort implements RankingSortInterface
{
    public function __invoke(array $teams): array
    {
        return $this->applyRanks($this->sortTeamsByScore($teams));
    }

    private function applyRanks(array $teams): array
    {
        $teamsRanks = [];

        $previousTeam = null;
        foreach ($teams as $index => $team) {
            $rank = $previousTeam && $previousTeam['scores'] === $team['scores'] ? $previousTeam['rank'] : ++$index;
            $teamsRanks[] = $previousTeam = array_merge(['rank' => $rank], $team);
        }

        return $teamsRanks;
    }

    private function sortTeamsByScore(array $teams): array
    {
        usort($teams, function (array $team, array $team2) {
            return $team2['scores'] <=> $team['scores'];
        });

        return $teams;
    }
}