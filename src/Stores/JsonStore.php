<?php

namespace Luffluo\LaravelSettings\Stores;

use InvalidArgumentException;
use Illuminate\Filesystem\Filesystem;
use Luffluo\LaravelSettings\AbstractStore;

class JsonStore extends AbstractStore
{
    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * 存储地址
     *
     * @var string
     */
    protected $path;

    /**
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files, $path = null)
    {
        $this->files = $files;

        $this->setPath($path ?? storage_path() . '/settings.json');
    }

    protected function read()
    {
        $contents = $this->files->get($this->path);

        $data = json_decode($contents, true);

        if (null === $data) {
            throw new \RuntimeException("Invalid JSON in {$this->path}");
        }

        return $data;
    }

    protected function write(array $data)
    {
        if ($data) {
            $contents = json_encode($data);
        } else {
            $contents = '{}';
        }

        $this->files->put($this->path, $contents);
    }

    public function setPath($path)
    {
        if (! $this->files->exists($path)) {
            $result = $this->files->put($path, '{}');

            if (false === $result) {
                throw new InvalidArgumentException("Could not write to {$path}");
            }
        }

        if (! $this->files->isWritable($path)) {
            throw new InvalidArgumentException("{$path} is not writable");
        }

        $this->path = $path;
    }
}
