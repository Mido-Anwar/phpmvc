<?php

namespace System;


class File
{
    /**
     * directory separator
     * 
     * 
     * @const string
     * 
     * 
     */
    const DS = DIRECTORY_SEPARATOR;
    /**
     *Root path of the application
     * 
     *  @var string
     *
     */
    private $root;

    /**
     * Constructor
     * @param string $root Root path of the application
     * 
     */

    public function __construct($root)
    {
        $this->root = $root;
    }

    /**
     * datermine if file exists
     * @param string $file
     * @return bool
     */
    public function exists($file)
    {

        return file_exists($file);
    }
    /**
     * require file
     * 
     * @param string $file
     * @return void
     */
    public function require($file)
    {
        require($file);
    }
    /**
     * genrate full path to the given file
     * @param string $path
     * @return string
     */

    public function toVendor($path)
    {
        return $this->to('vendor/' . $path);
    }
    /**
     * genrate full path to the given file
     * @param string $path
     * @return string
     */

    public function to($path)
    {
        return $this->root . static::DS . str_replace(['/', '\\'], static::DS, $path);
    }
}
