<?php
/**
 * This file contains RunTestsCommand class.
 *
 * @author Akbly Sofiane <sofiane.akbly@gmail.com>
 */

namespace Ssf\Copy\Commands;


use Ssf\Copy\Exceptions\ArgvNotExistsException;
use Ssf\Copy\Framework\Command;

/**
 * Class RunTestsCommand
 * @package Ssf\Copy\Commands
 * @see Command
 */
class RunTestsCommand extends Command
{

    /**
     * RunTestsCommand constructor.
     * @param array|null $argv Liste des arguments de php
     */
    public function __construct(array $argv = null)
    {
        parent::__construct($argv); // Constructeur de la classe mère
    }

    /**
     * @return int
     * @throws ArgvNotExistsException
     * @see Command::handle()
     */
    public function handle(): int
    {
        parent::handle(); // TODO: Change the autogenerated stub
        print shell_exec(__DIR__ . DIRECTORY_SEPARATOR . '../../vendor/bin/phpunit tests/ --colors=always');
        return 0;
    }

}