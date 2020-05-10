<?php

namespace SeeNotEvil\App;

use GuzzleHttp\Client;
use SeeNotEvil\RankingSport\Client\EndpointHttp;
use SeeNotEvil\RankingSport\Client\JsonParser;
use SeeNotEvil\RankingSport\Sort\SportRankingSort;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SeeNotEvil\RankingSport\Exception\ConnectionException;
use SeeNotEvil\RankingSport\Exception\InvalidResponseException;

class GetRankingSortCommand extends Command
{
    /**
     * @var EndpointHttp
     */
    private $client;
    /**
     * @var SportRankingSort
     */
    private $sort;

    protected static $defaultName = 'app:get-team-ranking';

    public function __construct(string $name = null)
    {
        $this->client = new EndpointHttp(new Client(), new JsonParser());
        $this->sort = new SportRankingSort();

        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Get ranking sort by endpoint')
            ->setHelp('Command...');
    }

    /**
     * @throws ConnectionException
     * @throws InvalidResponseException
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $teamList = $this->client->getTeamList($input->getArgument('url'));

        return json_encode($this->sort->sort($teamList), true);
    }
}