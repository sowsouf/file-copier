<?php
/**
 * This file contains Finder class
 * Cette classe permet de copier les fichiers
 * et les répertoires(*).
 *
 * @warning (*) La copie des répertoires complets n'est possible
 * qu'en local. Elle n'est pas prise en charge vers
 * un serveur distant
 *
 * @author Akbly Sofiane <sakbly@pndata.tech>
 */

namespace PNdata\Copy\Services;


use PNdata\Copy\Exceptions\CannotMkdirException;
use PNdata\Copy\Exceptions\FailedCopyException;
use PNdata\Copy\Exceptions\FileNotFoundException;
use PNdata\Copy\Services\Filesystems\FilesystemInterface;
use PNdata\Copy\Services\Filesystems\LocalFilesystem;
use PNdata\Copy\Services\Filesystems\SFTPFilesystem;
use PNdata\Copy\Tools\Helpers;

/**
 * Class Finder
 * @package PNdata\Copy\Services
 */
class Finder
{

    /**
     * @var bool $remote
     */
    private bool $remote;

    /**
     * Finder constructor.
     * @param bool $remote
     * @param array $remoteOptions
     */
    public function __construct(bool $remote = false, array $remoteOptions = array())
    {
        $this->remote = $remote;
        if ($remote === true) {
            $configRemoteParams = Helpers::config('filesystems.disks.sftp.params') ?? [];
            foreach ($configRemoteParams as $key => $param)
                Helpers::app()->register("filesystem.sftp.$key", $remoteOptions[$key] ?? $param);
            Helpers::app()->register('filesystem.sftp', SFTPFilesystem::getInstance());
        }
        Helpers::app()->register(
            'filesystem.local',
            LocalFilesystem::getInstance()
        );
    }


    /**
     * @param string $source
     * @param string $target
     * @param array $options
     * @return bool
     * @throws CannotMkdirException
     * @throws FailedCopyException
     * @throws FileNotFoundException
     */
    public function copy(string $source, string $target, array $options = ['override' => false, 'upload' => true])
    {
        $upload = isset($options['upload']) ? $options['upload'] : true;
        $filesystem = $this->filesystem($upload);
        if (!$this->filesystem(!$upload)->exists($source))
            throw new FileNotFoundException($source);

        $dirname = $filesystem->dirname($target);

        if (!$filesystem->isDirectory($dirname)) {
            if (!$filesystem->makeDirectory($dirname))
                throw new CannotMkdirException($dirname);
        }

        if ($this->filesystem(!$upload)->isFile($source))
            return $this->__copy($source, $target, $options);
        elseif ($this->filesystem(!$upload)->isDirectory($source)) return $this->__mirror($source, $target);
        else return false;
    }

    /**
     * @param string $source
     * @param string $target
     * @param array $options
     * @return bool
     * @throws FailedCopyException
     */
    private function __copy(string $source, string $target, array $options = ['override' => false, 'upload' => true])
    {
        $upload = isset($options['upload']) ? $options['upload'] : true;
        if ($this->filesystem($upload)->isDirectory($target))
            $target = str_replace(["//", "\/", "/\\"], DIRECTORY_SEPARATOR, $target . DIRECTORY_SEPARATOR . $this->filesystem($upload)->name($source));

        if ($this->filesystem()->copy($source, $target, $options))
            return true;
        throw new FailedCopyException($source, $target);
    }

    /**
     * @param string $source
     * @param string $target
     * @return bool
     * @throws FailedCopyException
     */
    private function __mirror(string $source, string $target)
    {
        if ($this->filesystem()->mirror($source, $target))
            return true;
        throw new FailedCopyException($source, $target);
    }

    /**
     * @param bool $remote
     * @return FilesystemInterface
     */
    public function filesystem($remote = true): FilesystemInterface
    {
        return $this->remote && $remote
            ? Helpers::app('filesystem.sftp')
            : Helpers::app('filesystem.local');
    }

}