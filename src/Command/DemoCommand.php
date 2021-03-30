<?php

namespace App\Command;

use App\Service\RedCallClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DemoCommand extends Command
{
    /**
     * @var RedCallClient
     */
    private $client;

    public function __construct(RedCallClient $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    protected function configure()
    {
        parent::configure();

        $this
            ->setName('demo')
            ->setDescription('RedCall API demo')
            ->addArgument('name', InputArgument::REQUIRED, 'What is your name?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = $this->client->demo(
            $input->getArgument('name')
        );

        var_dump($data);

        return 0;
    }
}