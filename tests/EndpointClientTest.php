<?php

namespace tests;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SeeNotEvil\RankingSport\Client\EndpointHttp;
use SeeNotEvil\RankingSport\EndpointClientInterface;
use SeeNotEvil\RankingSport\Exception\ConnectionException;
use SeeNotEvil\RankingSport\Exception\InvalidResponseException;
use SeeNotEvil\RankingSport\ParserContentInterface;

class EndpointClientTest extends TestCase
{
    /**
     * @var ClientInterface|MockObject
     */
    private $clientHttp;
    /**
     * @var EndpointClientInterface|MockObject
     */
    private $endpointClient;
    /**
     * @var ParserContentInterface|MockObject
     */
    private $parser;

    public function setUp(): void
    {
        $this->clientHttp = $this->createMock(ClientInterface::class);
        $this->parser = $this->createMock(ParserContentInterface::class);
        $this->endpointClient = new EndpointHttp($this->clientHttp, $this->parser);
    }

    public function testGetTeamList()
    {
        $expected = [
            ["team" => "Axiom", "score" => 99],
            ["team" => "BnL", "score" => 89]
        ];

        $result = <<<JSON
                [
                  {"team": "Axiom", "score": 99},
                  {"team": "BnL", "score": 89}
                ]
                JSON;

        $response = new Response(200, [], $result);

        $this->clientHttp
            ->expects($this->once())
            ->method("request")
            ->willReturn($response);

        $this->parser->expects($this->once())
            ->method("parse")
            ->with($result)
            ->willReturn($expected);

        $actual = $this->endpointClient->getTeamList("http://test");
        $this->assertEquals($expected, $actual);
    }

    public function testConnectionException()
    {
        $this->expectException(ConnectionException::class);
        $this->expectExceptionMessage("Connection error");

        $exception = $this->createMock(ClientException::class);

        $this->clientHttp
            ->expects($this->once())
            ->method("request")
            ->willThrowException($exception);

        $this->endpointClient->getTeamList("http://test");
    }

    public function testInvalidResponseException()
    {
        $this->expectException(InvalidResponseException::class);
        $this->expectExceptionMessage("Parse json error with code");

        $response = new Response(404, [], "-");

        $this->clientHttp
            ->expects($this->once())
            ->method("request")
            ->willReturn($response);

        $this->endpointClient->getTeamList("http://test");
    }
}