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
     * run the application
     * @return void
     */
    public function run()
    {
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
        if (!$this->isSharing($key)) {
            if ($this->isCoreAlias($key)) {
                $this->share($key, $this->createNewCoreObject($key));
            } else {
                die($key . ' not found in app container');
            }
        }
        return $this->container[$key];
    }

    /**
     * datermine if the given key is shared
     * @param string $key
     * @return bool
     */
    public function isSharing($key)
    {
        return   isset($this->container[$key]);
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
     * 
     * @param string $alias
     * @return bool
     */
    private function isCoreAlias($alias)
    {
        $coreClasses = $this->coreClasses();
        return isset($coreClasses[$alias]);
    }

    /**
     * create new object for the cor ebased on given alias
     * @param string $alias
     * @return object
     */
    private function createNewCoreObject($alias)
    {
        $coreClasses = $this->coreClasses();
        $object = $coreClasses[$alias];
        return new $object($this);
    }
    /**
     * get all core classes with its aliases
     * @return array
     */
    private function coreClasses()
    {

        return [
            'request'  => 'System\\Http\\Request',
            'response' => 'System\\Http\\Response ',
            'session'  => 'System\\Session',
            'cookie'   => 'System\\Cookie',
            'load'     => 'System\\Loader',
            'html'     => 'System\\Html',
            'db'       => 'System\\Database',
            'view'     => 'System\\View\\ViewFactory',
        ];
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
