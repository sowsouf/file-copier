<?php


use PHPUnit\Framework\TestCase;
use Ssf\Copy\Facades\Copy;

/**
 * Class CopyTest
 */
class CopyTest extends TestCase
{

    /**
     * @var Copy
     */
    public Copy $copy;

    /**
     * @var mixed|string
     */
    public string $path;

    /**
     * @var string
     */
    public string $fileContent;

    /**
     * CopyTest constructor.
     */
    public function __construct()
    {
        parent::__construct(get_class($this));
        $this->copy = new Copy();
        $this->path = \Ssf\Copy\Tools\Helpers::storage_path('files/tests');
        $this->fileContent = 'Je suis le contenu du fichier à tester';
    }

    /**
     * @throws \Ssf\Copy\Exceptions\CannotMkdirException
     * @throws \Ssf\Copy\Exceptions\FailedCopyException
     * @throws \Ssf\Copy\Exceptions\FileNotFoundException
     */
    public function testCopy()
    {
        if ($this->path && trim($this->path) !== '') {
            $this->empty($this->path);

            $filepath = $this->path . DIRECTORY_SEPARATOR . 'source';
            $file = $filepath . DIRECTORY_SEPARATOR . 'test.txt';
            @mkdir($filepath, 0777, true);

            file_put_contents($file, $this->fileContent);

            $this->copy->run($file, ($target = str_replace('source', 'target', $file)));

            $this->assertEquals($this->fileContent, file_get_contents($target));

            $this->empty($this->path);
        }

    }

    /**
     * @param $dirname
     */
    private function empty($dirname)
    {
        if (is_dir($dirname)) {
            $dir = new RecursiveDirectoryIterator($dirname, RecursiveDirectoryIterator::SKIP_DOTS);
            foreach (new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST) as $filename => $file) {
                if (is_file($filename))
                    unlink($filename);
                else
                    rmdir($filename);
            }
            rmdir($dirname); // Now remove myfolder
        }
    }

}