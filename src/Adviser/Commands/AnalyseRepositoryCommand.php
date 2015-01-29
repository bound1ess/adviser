<?php namespace Adviser\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface as Input;
use Symfony\Component\Console\Output\OutputInterface as Output;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

class AnalyseRepositoryCommand extends Command
{

    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName("analyse-repository")
             ->setDescription("Clones a GitHub repository and runs 'analyse' command on it");

        $this->addArgument("name", InputArgument::REQUIRED, "Repository name");
    }

    /**
     * Execute the command.
     *
     * @param Input $input
     * @param Output $output
     * @return void
     */
    protected function execute(Input $input, Output $output)
    {
        $output->writeln("Hello, world!");
    }
}
