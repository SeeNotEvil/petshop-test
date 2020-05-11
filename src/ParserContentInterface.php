<?php

namespace SeeNotEvil\RankingSport;

interface ParserContentInterface
{
    public function __invoke(string $content): array;
}