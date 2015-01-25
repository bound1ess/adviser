<?php namespace Adviser\Utility;

class File
{

    /**
     * Check if file/directory exists.
     *
     * @param string $path
     * @return boolean
     */
    public function exists($path)
    {
        return file_exists($path);
    }
}
