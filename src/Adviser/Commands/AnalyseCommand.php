<?php namespace Adviser\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface as Input;
use Symfony\Component\Console\Output\OutputInterface as Output;

use Adviser\Validators\ValidatorLoader;

class AnalyseCommand extends Command
{

    /**
     * @var ValidatorLoader
     */
    protected $loader;

    /**
     * @param ValidatorLoader|null $loader
     * @return AnalyseCommand
     */
    public function __construct(ValidatorLoader $loader = null)
    {
        $this->loader = $loader ?: new ValidatorLoader;

        parent::__construct();
    }

    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName("analyse")
             ->setDescription("Suggests you possible improvements for your project");
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
        list($directory, $projectName) = [getcwd(), basename(getcwd())];
        $validators = $this->loader->load();

        $output->write("Running Adviser for ");
        $output->writeln("<comment>{$directory}</comment> <info>[{$projectName}]</info>...");
        $output->writeln("Running <info>".count($validators)."</info> validators...");
        $output->writeln(PHP_EOL);

        foreach ($validators as $validator) {
            $output->writeln(
                "    Running <comment>".$validator->getName()."</comment> validator..."
            );
        }
    }
}
