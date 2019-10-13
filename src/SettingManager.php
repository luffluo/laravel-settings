<?php

namespace Luffluo\LaravelSettings;

use Illuminate\Support\Manager;
use Luffluo\LaravelSettings\Stores\JsonStore;
use Luffluo\LaravelSettings\Stores\RedisStore;

class SettingManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->app['config']->get('settings.store', 'json');
    }

    /**
     * 创建 json driver
     *
     * @return \Luffluo\LaravelSettings\Stores\JsonStore
     */
    public function createJsonDriver()
    {
        return new JsonStore($this->app['files'], $this->app['config']['settings.path']);
    }

    /**
     * 创建 Redis driver
     *
     * @return \Luffluo\LaravelSettings\Stores\RedisStore
     */
    public function createRedisDriver()
    {
        return new RedisStore($this->app['redis']->connection(), $this->app['config']['settings.redis.hash_name']);
    }
}
