<?php

namespace SeeNotEvil\RankingSport\Client;

use SeeNotEvil\RankingSport\Exception\InvalidResponseException;
use SeeNotEvil\RankingSport\ParserContentInterface;

class JsonParser implements ParserContentInterface
{
    /**
     * @throws InvalidResponseException
     */
    public function parse(string $content): array
    {
        $result = json_decode($content, true);

        if (!$result && $jsonError = json_last_error_msg()) {
            throw new InvalidResponseException(sprintf("Parse json error with code %s", $jsonError));
        }

        return $result;
    }
}