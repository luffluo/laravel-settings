<?php

namespace Luffluo\LaravelSettings;

use Illuminate\Support\Arr;

abstract class AbstractStore
{
    /**
     * @var array
     */
    protected $items = [];

    protected $loaded = false;

    protected $unsaved = false;

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
        $this->load();

        return Arr::has($this->items, $key);
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
        $this->read();

        if ($this->has($key)) {
            return Arr::get($this->items, $key);
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
        $this->load();
        $this->unsaved = true;

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->set($k, $v);
            }
        } else {
            Arr::set($this->items, $key, $value);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function all()
    {
        $this->load();

        return $this->items;
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
        $this->unsaved = true;

        if ($this->has($key)) {
            Arr::forget($this->items, $key);
        }

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
        $this->unsaved = true;
        $this->items = [];

        return $this;
    }

    public function load($force = false)
    {
        if (! $this->loaded || $force) {
            $this->items = $this->read();
            $this->loaded = true;
        }
    }

    /**
     * 保存配置信息到 setting.php 文件
     */
    public function save()
    {
        if (! $this->unsaved) {
            return;
        }

        $this->write($this->items);
        $this->unsaved = false;
    }

    abstract protected function read();

    abstract protected function write(array $data);
}