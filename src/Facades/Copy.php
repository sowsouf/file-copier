<?php
/**
 * This file contains Copy class
 * @author Akbly Sofiane <sofiane.akbly@gmail.com>
 */

namespace Ssf\Copy\Facades;

use Ssf\Copy\Exceptions\CannotMkdirException;
use Ssf\Copy\Exceptions\FailedCopyException;
use Ssf\Copy\Exceptions\FileNotFoundException;
use Ssf\Copy\Services\Finder;

/**
 * Class Copy
 * Cette classe permet d'utiliser la classe @see \Ssf\Copy\Services\Finder
 * de manière transparente.
 *
 * @package Ssf\Copy\Facades
 */
class Copy
{

    /**
     * @var Finder $finder L'objet Finder
     */
    private Finder $finder;

    /**
     * @var bool $download En cas de copie sur un serveur disant, sert à définir si la source est distante ou local.
     */
    private bool $download;
    /**
     * @var bool $remote Serveur distant ?
     */
    private bool $remote;

    /**
     * Copy constructor.
     * @param bool $remote
     * @param array $remoteOptions
     * @param bool $download
     */
    public function __construct(bool $remote = false, array $remoteOptions = array(), bool $download = false)
    {
        $this->finder = new Finder($remote, $remoteOptions);
        $this->download = $download;
        $this->remote = $remote;
    }

    /**
     * @param string $source Chemin du fichier source à copier
     * @param string $target Chemin destination où le fichier sera copié
     * @param array $options
     * @return bool
     * @throws CannotMkdirException
     * @throws FailedCopyException
     * @throws FileNotFoundException
     */
    public function run(string $source, string $target, array $options = ['override' => false, 'upload' => true])
    {
        if ($this->remote && $this->download)
            $options['upload'] = false;
        return $this->finder->copy($source, $target, $options);
    }

}