<?php

namespace SeeNotEvil\RankingSport;

interface RankingSortInterface
{
    public function __invoke(array $teams): array;
}