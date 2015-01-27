<?php namespace Adviser\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface as Input;
use Symfony\Component\Console\Output\OutputInterface as Output;

use Adviser\ValidatorLoader;

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

        $output->writeln("");

        list($normal, $warnings, $errors) = [0, 0, 0];

        foreach ($validators as $validator) {
            $output->writeln(
                "    Running <comment>".$validator->getName()."</comment> validator..."
            );

            // We don't want to run the validators in our unit tests.
            if (defined("ADVISER_UNDER_TEST")) {
                continue;
            }
            
            // @codeCoverageIgnoreStart
            $bag = $validator->handle();

            // Update the counters.
            $normal   += count($bag->getNormalMessages());
            $warnings += count($bag->getWarnings());
            $errors   += count($bag->getErrors());

            // Display the messages.
            $output->writeln("");

            foreach ($bag->getAll() as $message) {
                $output->writeln("        ".$message->format());
            }

            $output->writeln("");
            // @codeCoverageIgnoreStop
        }

        $output->writeln("");

        // Total:
        $output->write("<info>{$normal} OK</info> / ");
        $output->write("<comment>{$warnings} WARNINGS</comment> / ");
        $output->writeln("<error>{$errors} ERRORS</error>");

        $output->writeln("Done!");
    }
}
