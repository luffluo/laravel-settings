<?php

namespace Luffluo\LaravelSettings;

use Illuminate\Support\Manager;
use Luffluo\LaravelSettings\Stores\JsonStore;
use Luffluo\LaravelSettings\Stores\RedisStore;
use Luffluo\LaravelSettings\Stores\DatabaseStore;

class SettingManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->config('store', 'json');
    }

    /**
     * Create json driver
     *
     * @return \Luffluo\LaravelSettings\Stores\JsonStore
     */
    public function createJsonDriver()
    {
        return new JsonStore($this->app['files'], $this->config('path'));
    }

    /**
     * Create Database driver
     *
     * @return \Luffluo\LaravelSettings\Stores\DatabaseStore
     */
    public function createDatabaseDriver()
    {
        $connectionName = $this->config('connection');
        $connection     = $this->app['db']->connection($connectionName);
        $table          = $this->config('table');
        $keyColumn      = $this->config('key_column');
        $valueColumn    = $this->config('value_column');

        return new DatabaseStore($connection, $table, $keyColumn, $valueColumn);
    }

    /**
     * Create Redis driver
     *
     * @return \Luffluo\LaravelSettings\Stores\RedisStore
     */
    public function createRedisDriver()
    {
        return new RedisStore($this->app['redis']->connection(), $this->app['config']['settings.redis.hash_name']);
    }

    /**
     * Get config by key
     *
     * @param string $key
     * @return string|null
     */
    protected function config($key, $default = null)
    {
        return $this->app['config']->get('setting.' . $key, $default);
    }
}
