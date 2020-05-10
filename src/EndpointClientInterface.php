<?php

namespace SeeNotEvil\RankingSport;

interface EndpointClientInterface
{
    public function getTeamList(string $url): array;
}