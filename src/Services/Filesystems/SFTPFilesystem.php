<?php
/**
 * This file contains SFTPFilesystem
 * @author Akbly Sofiane <sofiane.akbly@gmail.com>
 */

namespace Ssf\Copy\Services\Filesystems;


use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\PhpseclibV2\SftpAdapter;
use League\Flysystem\PhpseclibV2\SftpConnectionProvider;
use League\Flysystem\StorageAttributes;
use Ssf\Copy\Facades\File;
use Ssf\Copy\Tools\Helpers;

/**
 * Class SFTPFilesystem
 * Cette classe implémente @see \Ssf\Copy\Services\Filesystems\FilesystemInterface
 *
 * @package Ssf\Copy\Services\Filesystems
 */
class SFTPFilesystem implements FilesystemInterface
{

    /**
     * @var Filesystem $filesystem
     */
    private Filesystem $filesystem;

    /**
     * @var mixed $adapter
     */
    public $adapter;

    /**
     * @var SFTPFilesystem|null
     * @access private
     * @static
     */
    private static ?SFTPFilesystem $_instance = null;

    /**
     * Constructeur de la classe
     *
     * @param void
     * @return void
     */
    private function __construct()
    {
        $this->filesystem = new Filesystem(
            new SftpAdapter(
                new SftpConnectionProvider(
                    Helpers::app('filesystem.sftp.host'),
                    Helpers::app('filesystem.sftp.user'),
                    Helpers::app('filesystem.sftp.password'),
                    Helpers::app('filesystem.sftp.privateKey'),
                    Helpers::app('filesystem.sftp.passphrase'),
                    Helpers::app('filesystem.sftp.port'),
                    Helpers::app('filesystem.sftp.useAgent'),
                    Helpers::app('filesystem.sftp.timeout'),
                    Helpers::app('filesystem.sftp.maxTries'),
                    Helpers::app('filesystem.sftp.fingerprint'),
                    Helpers::app('filesystem.sftp.checker'),
                ),
                Helpers::config('filesystems.disks.sftp.root', '/')
            )
        );
    }


    /**
     * Méthode qui crée l'unique instance de la classe
     * si elle n'existe pas encore puis la retourne.
     *
     * @param void
     * @return SFTPFilesystem()
     */
    public static function getInstance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new SFTPFilesystem();
        }

        return self::$_instance;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function exists(string $path): bool
    {
        try {
            return $this->filesystem->fileExists($path);
        } catch (FilesystemException $e) {
            Helpers::signal($e, true);
            return false;
        }
    }

    /**
     * @param string $path
     * @return bool
     * @throws FilesystemException
     */
    public function isDirectory(string $path): bool
    {
        return $this->exists($path) && in_array($this->dirname($path), $this->filesystem->listContents(dirname($path))
                ->filter(fn(StorageAttributes $attributes) => $attributes->isDir())
                ->map(fn(StorageAttributes $attributes) => $attributes->path())
                ->toArray());
    }

    /**
     * @param string $path
     * @return bool
     */
    public function isFile(string $path): bool
    {
        return $this->exists($path);
    }

    /**
     * @param iterable|string $dirs
     * @param int $mode
     * @return bool
     */
    public function makeDirectory($dirs, int $mode = 0777): bool
    {
        try {
            $this->filesystem->createDirectory($dirs, ['mode' => $mode]);
            return true;
        } catch (FilesystemException $exception) {
            return false;
        }
    }

    /**
     * @param string $filepath
     * @return string
     */
    public function name(string $filepath): string
    {
        return basename($filepath);
    }

    /**
     * @param string $path
     * @param array $separators
     * @return string
     */
    public function dirname(string $path, array $separators = ['/', '\\']): string
    {
        return File::dirname($path, $separators);
    }

    /**
     * @param string $source
     * @param string $target
     * @param array $options
     * @return bool
     */
    public function copy(string $source, string $target, array $options = array()): bool
    {
        try {
            if ($options['upload'] === true) {
                $this->filesystem->writeStream($target, ($resource = fopen($source, 'r')));
                fclose($resource);
            } elseif ($options['upload'] === false) {
                $stream = $this->filesystem->readStream($source);
                file_put_contents($target, $stream);
            }
            return true;
        } catch (FilesystemException $e) {
            Helpers::signal($e, true);
            return false;
        }
    }

    /**
     * @param string $source
     * @param string $target
     * @return bool
     */
    public function mirror(string $source, string $target): bool
    {
        return false;
        /*try {
//            $this->filesystem->copy($source, $target);
            return true;
        } catch (FilesystemException $e) {
            signal($e, true);
            return false;
        }*/
    }

}