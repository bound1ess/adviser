<?php namespace Adviser\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface as Input;
use Symfony\Component\Console\Output\OutputInterface as Output;

class GiveAdviceCommand extends Command
{

    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName("give-advice")
             ->setDescription("Suggests you possible improvements");
    }

    /**
     * Execute the command.
     *
     * @param  Input  $input
     * @param  Output $output
     * @return void
     */
    protected function execute(Input $input, Output $output)
    {
        $output->writeln("Hello, world!");
    }
}
