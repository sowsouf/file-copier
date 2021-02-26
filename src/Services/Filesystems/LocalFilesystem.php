<?php
/**
 * This file contains LocalFilesystem
 * Cette classe implémente @see \PNdata\Copy\Services\Filesystems\FilesystemInterface
 *
 * @author Akbly Sofiane <sakbly@pndata.tech>
 */

namespace PNdata\Copy\Services\Filesystems;


use PNdata\Copy\Facades\File;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class LocalFilesystem
 * @package PNdata\Copy\Services\Filesystems
 */
class LocalFilesystem implements FilesystemInterface
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
     * @var LocalFilesystem|null
     * @access private
     * @static
     */
    private static ?LocalFilesystem $_instance = null;

    /**
     * Constructeur de la classe
     *
     * @param void
     * @return void
     */
    private function __construct()
    {
        $this->filesystem = new Filesystem();

        // TODO : Créer un adapter filesystem
        //      Créer l'objet filesystem qui servira à gérer les fichiers
    }


    /**
     * Méthode qui crée l'unique instance de la classe
     * si elle n'existe pas encore puis la retourne.
     *
     * @param void
     * @return LocalFilesystem
     */
    public static function getInstance()
    {

        if (is_null(self::$_instance)) {
            self::$_instance = new LocalFilesystem();
        }

        return self::$_instance;
    }

    /**
     * @param string $path
     * @return bool
     */
    public function exists(string $path): bool
    {
        return $this->filesystem->exists($path);
    }

    /**
     * @param string $path
     * @return bool
     */
    public function isDirectory(string $path): bool
    {
        return $this->exists($path) && is_dir($path);
    }

    /**
     * @param string $path
     * @return bool
     */
    public function isFile(string $path): bool
    {
        return $this->exists($path) && is_file($path);
    }

    /**
     * @param iterable|string $dirs
     * @param int $mode
     * @return bool
     */
    public function makeDirectory($dirs, int $mode = 0777): bool
    {
        try {
            $this->filesystem->mkdir($dirs, $mode);
            return true;
        } catch (IOExceptionInterface $exception) {
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
            $this->filesystem->copy($source, $target, $options['override'] ?? false);
            return true;
        } catch (IOExceptionInterface $exception) {
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
        try {
            $this->filesystem->mirror($source, $target);
            return true;
        } catch (IOExceptionInterface $exception) {
            return false;
        }
    }

    /**
     * @return Filesystem
     */
    public function getFilesystem(): Filesystem
    {
        return $this->filesystem;
    }

}