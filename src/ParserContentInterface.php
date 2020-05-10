<?php

namespace SeeNotEvil\RankingSport;

interface ParserContentInterface
{
    public function parse(string $content): array;
}