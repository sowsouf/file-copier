<?php


namespace Ssf\Copy\Framework;


use Ssf\Copy\Commands\CopyCommand;

/**
 * Class Application
 * @package Ssf\Copy\Framework
 */
class Application
{

    /**
     * @var string|null
     */
    private ?string $basePath;

    /**
     * Application constructor.
     * @param string|null $basePath
     */
    public function __construct(?string $basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }
    }

    /**
     * @param string $basePath
     */
    public function setBasePath(string $basePath)
    {
        $this->basePath = rtrim($basePath, '\/');
    }

    /**
     * @param array $argv
     * @param Command|null $command
     * @return Command
     */
    public function make(array $argv, Command $command = null)
    {
        $command = $command ?? new CopyCommand();
        $command->setParameters($argv);
        return $command;
    }

    /**
     * @param $abstract
     * @param null $concrete
     * @return Container|null
     */
    public function singleton($abstract, $concrete = null)
    {
        return Container::getInstance()->register($abstract, $concrete);
    }

}