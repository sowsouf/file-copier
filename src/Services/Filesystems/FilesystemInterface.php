<?php
/**
 * This file contains FilesystemInterface
 * @author Akbly Sofiane <sofiane.akbly@gmail.com>
 */

namespace Ssf\Copy\Services\Filesystems;


/**
 * Interface FilesystemInterface
 * Cette inferface contient les méthodes utiles
 * à implémenter pour la gestion des fichiers
 * systèmes.
 *
 * @package Ssf\Copy\Services\Filesystems
 */
interface FilesystemInterface
{

    /**
     * @param string $path
     * @return bool
     */
    public function exists(string $path): bool;

    /**
     * @param string $path
     * @return bool
     */
    public function isDirectory(string $path): bool;

    /**
     * @param string $path
     * @return bool
     */
    public function isFile(string $path): bool;

    /**
     * @param iterable|string $dirs
     * @param int $mode
     * @return bool
     */
    public function makeDirectory($dirs, int $mode = 0777): bool;

    /**
     * @param string $filepath
     * @return string
     */
    public function name(string $filepath): string;

    /**
     * @param string $path
     * @param array $separators
     * @return string
     */
    public function dirname(string $path, array $separators = ['/', '\\']): string;

    /**
     * @param string $source
     * @param string $target
     * @param array $options
     * @return bool
     */
    public function copy(string $source, string $target, array $options = array()): bool;

    /**
     * @param string $source
     * @param string $target
     * @return bool
     */
    public function mirror(string $source, string $target): bool;
}