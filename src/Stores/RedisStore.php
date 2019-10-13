<?php

declare(strict_types = 1);

namespace Luffluo\LaravelSettings\Stores;

use Luffluo\LaravelSettings\AbstractStore;

class RedisStore extends AbstractStore
{
    /**
     * @var \Illuminate\Redis\Connections\Connection
     */
    protected $redis;

    /**
     * 集合的 名称
     * @var string
     */
    protected $hashName = 'settings';

    public function __construct(\Illuminate\Redis\Connections\Connection $redis, $hasName = null)
    {
        $this->redis = $redis;

        if ($hasName) {
            $this->hashName = $hasName;
        }
    }

    /**
     * Determine if the given option value exists.
     *
     * @param     $key
     * @param int $user_id
     *
     * @return bool
     */
    public function has($key)
    {
        return (bool) $this->redis->hexists($this->hashName, $key);
    }

    /**
     * Get the specified option value.
     *
     * @param      $key
     * @param null $default
     * @param int  $userId
     *
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            return json_decode($this->redis->hget($this->hashName, $key) ?? '', true);
        }

        return $default;
    }

    /**
     * Set a given option value
     *
     * @param     $key
     * @param     $value
     * @param int $userId
     *
     * @return self
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }
        } else {
            $this->redis->hset($this->hashName, $key, json_encode($value));
        }

        $this->unsaved = false;

        return $this;
    }

    /**
     * @return array
     */
    public function all()
    {
        $keys = $this->redis->hkeys($this->hashName);

        $items = [];

        foreach ($keys as $key) {
            $items[$key] = $this->get($key);
        }

        return $items;
    }

    /**
     * Forget current option value.
     *
     * @param     $key
     * @param int $user_id
     *
     * @return self
     */
    public function forget($key)
    {
        if ($this->has($key)) {
            $this->redis->hdel($this->hashName, $key);
        }

        $this->unsaved = false;

        return $this;
    }

    /**
     * Forget current option value.
     *
     * @param     $key
     * @param int $user_id
     *
     * @return self
     */
    public function forgetAll()
    {
        $keys = $this->redis->hkeys($this->hashName);

        foreach ($keys as $key) {
            $this->redis->hdel($this->hashName, $key);
        }

        $this->unsaved = false;

        return $this;
    }

    protected function read()
    {
    }

    protected function write(array $data)
    {
    }
}
