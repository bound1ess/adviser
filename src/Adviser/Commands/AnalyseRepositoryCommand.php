<?php namespace Adviser\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface as Input;
use Symfony\Component\Console\Output\OutputInterface as Output;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\ArrayInput;

use Adviser\Utilities\GitUtility;

class AnalyseRepositoryCommand extends Command
{

    /**
     * @var Git
     */
    protected $git;

    /**
     * @param GitUtility|null $git
     * @return AnalyseRepositoryCommand
     */
    public function __construct(GitUtility $git = null)
    {
        $this->git = $git ?: new GitUtility();

        parent::__construct();
    }

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
        $name = $input->getArgument("name");

        // Validate the name straight away.
        if (count($chunks = explode("/", $name)) != 2) {
            throw new \InvalidArgumentException("Invalid repository name '{$name}'.");
        }

        $output->writeln(sprintf(
            "Cloning <comment>%s</comment> into <info>./%s</info>...",
            $name,
            end($chunks)
        ));

        // If we're in a test environment, stop executing.
        if (defined("ADVISER_UNDER_TEST")) {
            return null;
        }

        // @codeCoverageIgnoreStart

        if ( ! $this->git->cloneGithubRepository($name)) {
            throw new \UnexpectedValueException(
                "Repository https://github.com/{$name} doesn't exist."
            );
        }

        // @codeCoverageIgnoreStop
    }
}
