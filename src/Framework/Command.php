<?php
/**
 * This file contains Command class.
 * Cette classe est la classe mère des commandes.
 * Chaque commande console est définie de manière identique :
 *  - Un nom
 *  - Des arguments / options
 *
 * @author Akbly Sofiane <sofiane.akbly@gmail.com>
 */

namespace Ssf\Copy\Framework;


use Ssf\Copy\Exceptions\ArgvNotExistsException;

/**
 * Class Command
 * @package Ssf\Copy\Framework
 */
class Command implements Kernel
{

    /**
     * @var array $arguments Liste des arguments
     */
    protected array $arguments;
    /**
     * @var array $options Liste des options
     */
    protected array $options;

    /**
     * @var array $parameters Tableau contenant les argv de PHP
     */
    protected array $parameters;

    /**
     * @var array $signature Signature de la commande
     */
    protected array $signature = [];

    /**
     * @var string $name Nom de la commande
     */
    protected string $name = 'copy';

    /**
     * Command constructor.
     * @param array|null $argv
     */
    public function __construct(array $argv = null)
    {
        if ($argv) {
            $this->setParameters($argv);
        }
    }

    /**
     * Récupération des argv de PHP et
     * séparations en arguments & options.
     *
     * @param array $argv
     */
    public function setParameters(array $argv)
    {
        unset($argv[0]);
        $this->parameters = $argv;

        $this->setArguments(
            array_filter($this->parameters,
                fn($parameter) => strpos($parameter, '=') === false
            )
        );
        $this->setOptions(
            array_filter($this->parameters,
                fn($parameter) => strpos($parameter, '=') !== false
            )
        );

    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments)
    {
        if (count($arguments) > 0 && !is_string(array_keys($arguments)[0]))
            $arguments = array_combine(
                array_map(fn($item) => explode('=', $item)[0], $arguments),
                array_map(fn($item) => true, $arguments),
            );
        $this->arguments = $arguments;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        if (count($options) > 0 && !is_string(array_keys($options)[0]))
            $options = array_combine(
                array_map(fn($item) => explode('=', $item)[0], $options),
                array_map(fn($item) => explode('=', $item)[1], $options),
            );
        $this->options = $options;
    }

    /**
     * Validation des valeurs avec les règles définies.
     *
     * @return bool
     * @throws ArgvNotExistsException
     */
    public function valid()
    {
        $arguments = array_keys($this->arguments);
        $options = array_keys($this->options);

        $signatureArguments = $this->signatureParameters('arguments');
        $signatureOptions = $this->signatureParameters('options');

        foreach ($arguments as $argument) {
            if ($argument !== '--help' && !in_array($argument, $signatureArguments))
                throw new ArgvNotExistsException('argument', $argument, $this->name);
        }

        foreach ($options as $option) {
            if (!in_array($option, $signatureOptions))
                throw new ArgvNotExistsException('option', $option, $this->name);
        }
        return true;
    }

    /**
     * @access private
     * @param $type
     * @param bool $map
     * @return array|mixed
     */
    private function signatureParameters($type, $map = true)
    {
        $filtered = array_values(array_filter(
                $this->signature,
                fn($item) => $item['type'] === $type
            )
        );
        return count($filtered) > 0
            ? ($map ? array_map(fn($item) => $item['name'], $filtered[0]['values']) : $filtered[0]['values'])
            : array();
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    protected function option(string $key)
    {
        $options = array_map(
            fn($item) => str_replace('--', '', $item),
            array_keys($this->options)
        );
        return in_array($key, $options)
            ? $this->options["--$key"]
            : ((array_values(
                    array_filter($this->signatureParameters('options', false), fn($item) => $item['name'] === "--$key", ARRAY_FILTER_USE_BOTH)
                )[0]) ?? ['default' => null])['default'];
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    protected function argument(string $key)
    {
        $arguments = array_map(
            fn($item) => str_replace('--', '', $item),
            array_keys($this->arguments)
        );
        return in_array($key, $arguments)
            ? $this->arguments["--$key"]
            : ((array_values(
                    array_filter($this->signatureParameters('arguments', false), fn($item) => $item['name'] === "--$key", ARRAY_FILTER_USE_BOTH)
                )[0]) ?? ['default' => null])['default'];
    }

    /**
     * @return int
     * @throws ArgvNotExistsException
     */
    public function handle(): int
    {
        if (isset($this->arguments['--help'])) {
            echo sprintf("\033[33m%s\033[0m%s [options]%s%s", 'Usage:' . PHP_EOL, $this->name, PHP_EOL . PHP_EOL, $this->help());
            return 0;
        } else
            return $this->valid()
                ? 0 : 1;
    }

    /**
     * @access private
     * @return string
     */
    private function help(): string
    {
        $options = (array_values(array_filter($this->signature, fn($item) => $item['type'] === 'options'))[0] ?? [])['values'] ?? null;
        $arguments = (array_values(array_filter($this->signature, fn($item) => $item['type'] === 'arguments'))[0] ?? [])['values'] ?? null;

        return $this->helpField($options, true) . PHP_EOL . $this->helpField($arguments);
    }

    /**
     * @access private
     * @param array $values
     * @param bool $isOption
     * @return string
     */
    private function helpField(array $values, bool $isOption = false)
    {
        return sprintf("\033[33m%s:\033[0m", $isOption ? 'Options' : 'Arguments') . PHP_EOL . "    " . implode(PHP_EOL . "    ",
                array_map(fn($item) => sprintf(
                    "\033[32m%s%s\033[0m%s%s %s%s",
                    $item['name'],
                    $isOption ? strtoupper(str_replace('--', '[=', $item['name'])) . ']' : '',
                    "\t",
                    $item['description'],
                    "\033[33m(default: " . strval($item['default'] ?? 'null') . ")\033[0m",
                    ($item['required'] ? " \033[31m** OBLIGATOIRE **\033[0m" : '')
                ), $values)
            ) . PHP_EOL;
    }

    /**
     * Permet de renseigner une chaîne de caractère
     * dans un champ caché.
     *
     * @param string|null $question
     * @return string
     */
    public function secret(string $question = null): string
    {
        if (strcasecmp(substr(PHP_OS, 0, 3), 'WIN') == 0) {
            $exe = __DIR__ . '/Resources/bin/hiddeninput.exe';

            $sExec = shell_exec($exe);
            return rtrim($sExec);
        } else {
            echo sprintf("\033[32m%s\033[0m%s", $question, PHP_EOL);
            shell_exec('stty -echo');
            $value = trim(fgets(STDIN));
            shell_exec('stty echo');
            return $value;
        }


        /*if ('\\' === \DIRECTORY_SEPARATOR) {
            $exe = __DIR__.'/../Resources/bin/hiddeninput.exe';

            // handle code running from a phar
            if ('phar:' === substr(__FILE__, 0, 5)) {
                $tmpExe = sys_get_temp_dir().'/hiddeninput.exe';
                copy($exe, $tmpExe);
                $exe = $tmpExe;
            }

            $sExec = shell_exec($exe);
            $value = $trimmable ? rtrim($sExec) : $sExec;
            $output->writeln('');

            if (isset($tmpExe)) {
                unlink($tmpExe);
            }

            return $value;
        }*/
    }
}