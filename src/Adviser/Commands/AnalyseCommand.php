<?php namespace Adviser\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface as Input;
use Symfony\Component\Console\Output\OutputInterface as Output;
use Symfony\Component\Console\Input\InputOption;

use Adviser\Loaders\ValidatorLoader, Adviser\Loaders\FormatterLoader;
use Adviser\Validators\ValidatorInterface;
use Adviser\Output\MessageBag;

class AnalyseCommand extends Command
{

    /**
     * @var ValidatorLoader
     */
    protected $loader;

    /**
     * @var array
     */
    protected $messageCounter = [
        "normal"  => 0,
        "warning" => 0,
        "error"   => 0,
    ];

    /**
     * @var array
     */
    protected $validators = [];

    /**
     * @var null|string
     */
    protected $formatter;

    /**
     * @var array
     */
    protected $formatters = [];

    /**
     * Four spaces.
     *
     * @var string
     */
    protected $indentation = "    ";

    /**
     * @param ValidatorLoader|null $validatorLoader
     * @param FormatterLoader|null $formatterLoader
     * @return AnalyseCommand
     */
    public function __construct(ValidatorLoader $validatorLoader = null,
        FormatterLoader $formatterLoader = null)
    {
        $this->validatorLoader = $validatorLoader ?: new ValidatorLoader();
        $this->formatterLoader = $formatterLoader ?: new FormatterLoader();

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

        $this->addOption("formatter", null, InputOption::VALUE_REQUIRED, "Output formatter");
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
        $this->validators = $this->validatorLoader->loadFromConfigurationFile();

        $this->formatter = $input->getOption("formatter");
        $this->formatters = $this->formatterLoader->loadFromConfigurationFile();

        if ( ! $this->useFormatter($output)) {
            $this->writeHead($output);

            foreach ($this->validators as $validator) {
                $this->runValidator($validator, $output);
            }

            $this->writeSummary($output);
        }
    }

    /**
     * If a formatter was specified, run it, return true. Otherwise, return false.
     * @codeCoverageIgnore
     *
     * @param Output $output
     * @return boolean
     */
    protected function useFormatter(Output $output)
    {
        if (is_null($this->formatter)) {
            return false;
        }

        if ( ! array_key_exists($this->formatter, $this->formatters)) {
            throw new \InvalidArgumentException(
                "Invalid formatter name '{$this->formatter}'."
            );
        }

        $output->writeln("Running formatter <comment>{$this->formatter}</comment>...");
        $output->writeln("");

        $bag = new MessageBag();
        $startTime = microtime(true);

        foreach ($this->validators as $validator) {
            $bag = new MessageBag(array_merge(
                $validator->handle()->getAll(),
                $bag->getAll()
            ));
        }

        $output->writeln($this->formatters[$this->formatter]->format($bag));

        $output->writeln("");
        $output->writeln(sprintf(
            "Done in %s seconds.",
            round(microtime(true) - $startTime, 5)
        ));

        return true;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param ValidatorInterface $validator
     * @param Output $output
     * @return void
     */
    protected function runValidator(ValidatorInterface $validator, Output $output)
    {
        // We don't want to run the validators in our unit tests.
        if (defined("ADVISER_UNDER_TEST")) {
            return null;
        }

        $output->write($this->indentation);
        $output->writeln("Running <comment>".$validator->getName()."</comment> validator...");

        $startTime = microtime(true);

        $bag = $validator->handle();

        // Display how many seconds it took to run this validator.
        $output->write($this->indentation);
        $output->write("Done in ");
        $output->write(round(microtime(true) - $startTime, 5));
        $output->writeln(" seconds.");

        // Update the counters.
        $this->messageCounter['normal']  += count($bag->getNormalMessages());
        $this->messageCounter['warning'] += count($bag->getWarnings());
        $this->messageCounter['error']   += count($bag->getErrors());

        $output->writeln("");

        // Display the messages stored in the bag.
        foreach ($bag->getAll() as $message) {
            $output->write(str_repeat($this->indentation, 2));
            $output->writeln($message->format());
        }

        $output->writeln("");
    }

    /**
     * @param Output $output
     * @return void
     */
    protected function writeHead(Output $output)
    {
        $directory = getcwd();
        $projectName = basename($directory);

        $output->write("Running Adviser for ");
        $output->writeln("<comment>{$directory}</comment> <info>[{$projectName}]</info>...");
        $output->writeln("Running <info>".count($this->validators)."</info> validators...");

        $output->writeln("");
    }

    /**
     * @param Output $output
     * @return void
     */
    protected function writeSummary(Output $output)
    {
        $output->writeln("");

        $output->write("<info>{$this->messageCounter['normal']} OK</info>, ");
        $output->write("<comment>{$this->messageCounter['warning']} WARNING(S)</comment>, ");
        $output->writeln("<error>{$this->messageCounter['error']} ERROR(S)</error>");

        $output->writeln("Done!");
    }
}
