<?php namespace Adviser;

use Adviser\Utilities\FileUtility, Adviser\Utilities\YAMLParserUtility;

class ConfigurationLoader
{

    /**
     * @var FileUtility
     */
    protected $file;

    /**
     * @param FileUtility|null $file
     * @param YAMLParserUtility|null $parser
     * @return ConfigurationLoader
     */
    public function __construct(FileUtility $file = null, YAMLParserUtility $parser = null)
    {
        $this->file = $file ?: new FileUtility();
        $this->parser = $parser ?: new YAMLParserUtility();
    }

    /**
     * Load the YAML configuration file and parse it to array.
     *
     * @param boolean $searchInWorkingDir
     * @return array
     */
    public function load($searchInWorkingDir = true)
    {
        if ($searchInWorkingDir && $this->file->exists($path = getcwd()."/adviser.yml")) {
            return array_merge_recursive(
                $this->load(false),
                $this->parser->parse($this->file->read($path))
            );
        }

        return $this->parser->parse($this->file->read(ADVISER_DIR."/adviser-default.yml"));
    }
}
