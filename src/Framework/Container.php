<?php


namespace PNdata\Copy\Framework;


/**
 * Class Container
 * @package PNdata\Copy\Framework
 */
class Container
{

    /**
     * The current globally available container (if any).
     *
     * @var Container|null
     */
    protected static ?Container $instance = null;

    /**
     * @var array $singletons
     */
    protected array $singletons;

    /**
     * Container constructor.
     */
    private function __construct()
    {
        $this->singletons = array();
    }

    /**
     * @param $abstract
     * @param null $concrete
     * @return $this
     */
    public function register($abstract, $concrete = null)
    {
        if (!is_null($concrete))
            $this->singletons[$abstract] = $concrete;
        return $this;
    }

    /**
     * @param $abstract
     * @return mixed|null
     */
    public function resolve($abstract)
    {
        if (!is_null($abstract))
            return $this->singletons[$abstract] ?? null;
        return null;
    }

    /**
     * Get the globally available instance of the container.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new Container();
        }

        return static::$instance;
    }
}