<?php

namespace System;

class Application
{

    /**
     * container
     * @var array
     */
    private $container = [];
    /**
     *constructor
     * 
     *  @param  \System\File $file
     */

    public function __construct(File $file)
    {
        $this->share('file', $file);
        $this->registerClasses();
        $this->loadHelpers();

        pre($this->file);
    }

    /**
     * register classes in spl
     * 
     * @return void
     */
    private function registerClasses()
    {
        spl_autoload_register([$this, 'load']);
    }
    /**
     * load class
     *
     * @param string $class
     * @return void
     */
    public function load($class)
    {
        if (strpos($class, 'App') === 0) {

            $file = $this->file->to($class . '.php');
        } else {
            $file = $this->file->toVendor($class . '.php');
        }
        if ($this->file->exists($file)) {
            $this->file->require($file);
        }
    }
    /**
     * Load Helpers
     * @return void
     */
    private function loadHelpers()
    {
        $this->file->require($this->file->toVendor('helpers.php'));
    }
    /**
     * get value
     * 
     * @param string $key
     * @return mixed value
     */


    public function get($key)
    {
        return isset($this->container[$key]) ? $this->container[$key] : null;
    }
    /**
     * Get an instance of the given class.
     *
     * @param  string $key
     * @param mixed $value
     * @return mixed
     */
    public function share($key, $value)
    {
        $this->container[$key] = $value;
    }
    /**
     * get shered value dynamically
     * 
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }
}
