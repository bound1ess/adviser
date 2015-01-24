<?php namespace Adviser\Utility;

class Composer
{

    /**
     * Check if there is a composer.json file in $directory.
     *
     * @param string $directory
     * @return boolean
     */
    public function manifestExists($directory)
    {
        return file_exists($directory."/composer.json");
    }
}
