<?php

namespace Luffluo\LaravelSettings;

use Illuminate\Support\Manager;
use Luffluo\LaravelSettings\Stores\JsonStore;

class SettingManager extends Manager
{
    /**
     * @var \Luffluo\LaravelSettings\Stores\FileStore
     */
    protected $fileRepository;

    /**
     * @var \Luffluo\LaravelSettings\Stores\DatabaseStore
     */
    protected $databaseRepository;

    /**
     * 应该被转换成原生类型的属性
     *
     * @var array
     */
    protected $casts = [];

    public function getDefaultDriver()
    {
        return $this->app['config']['settings.store'];
    }

    public function createJsonDriver()
    {
        return new JsonStore($this->app['files'], $this->app['config']['settings.path']);
    }
}
