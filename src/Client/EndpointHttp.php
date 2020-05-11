<?php

namespace SeeNotEvil\RankingSport\Client;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use SeeNotEvil\RankingSport\EndpointClientInterface;
use SeeNotEvil\RankingSport\Exception\ConnectionException;
use SeeNotEvil\RankingSport\Exception\InvalidResponseException;
use SeeNotEvil\RankingSport\ParserContentInterface;

class EndpointHttp implements EndpointClientInterface
{
    /**
     * @var ClientInterface
     */
    private $client;
    /**
     * @var JsonParser
     */
    private $parser;

    public function __construct(ClientInterface $client, ParserContentInterface $parser)
    {
        $this->client = $client;
        $this->parser = $parser;
    }

    /**
     * @throws ConnectionException
     * @throws InvalidResponseException
     */
    public function getTeamList(string $url): array
    {
        try {
            $result = $this->client->request("GET", $url);
        } catch (GuzzleException $exception) {
            throw new ConnectionException("Connection error", 0, $exception);
        }
        return ($this->parser)($result->getBody()->getContents());
    }
}