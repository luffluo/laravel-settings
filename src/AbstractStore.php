<?php

namespace Luffluo\LaravelSettings;

use Illuminate\Support\Arr;

abstract class AbstractStore
{
    /**
     * Cache key for save
     */
    const CACHE_KEY = 'setting:cache';

    /**
     * The setting data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Whether the store has changed since it was last loaded.
     *
     * @var boolean
     */
    protected $unsaved = false;

    /**
     * Whether the setting data are loaded.
     *
     * @var boolean
     */
    protected $loaded = false;

    /**
     * Get a specific key from the setting data.
     *
     * @param string|array $key
     * @param mixed $default Optional default value.
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $this->load();

        return Arr::get($this->data, $key, $default);
    }

    /**
     * Determine if a key exists in the setting data.
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        $this->load();

        return Arr::has($this->data, $key);
    }

    /**
     * Set a specific key to a value in the setting data.
     *
     * @param string|array $key Key string or associative array of key => value
     * @param mixed $value Optional only if the first argument is an array
     * @return static
     */
    public function set($key, $value = null)
    {
        $this->load();

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                Arr::set($this->data, $k, $v);
            }
        } else {
            Arr::set($this->data, $key, $value);
        }

        $this->unsaved = true;

        return $this;
    }

    /**
     * Unset a key in the setting data.
     *
     * @param string $key
     * @return static
     */
    public function forget($key)
    {
        if ($this->has($key)) {
            Arr::forget($this->data, $key);
        }

        $this->unsaved = true;

        return $this;
    }

    /**
     * Unset all keys in the setting data.
     *
     * @return static
     */
    public function forgetAll()
    {
        $this->unsaved = true;
        $this->data    = [];

        return $this;
    }

    /**
     * Get all setting data.
     *
     * @return array
     */
    public function all()
    {
        $this->load();

        return $this->data;
    }

    /**
     * Save any changes done to the setting data.
     *
     * @return void
     */
    public function save()
    {
        if (!$this->unsaved) {
            // either nothing has been changed, or data has not been loaded, so
            // do nothing by returning early
            return;
        }

        if (config('setting.forget_cache_by_write')) {
            cache()->forget(static::CACHE_KEY);
        }

        $this->write($this->data);
        $this->unsaved = false;
    }

    /**
     * Make sure data is loaded.
     *
     * @param $force Force a reload of data. Default false.
     */
    public function load($force = false)
    {
        if (!$this->loaded || $force) {
            $this->data   = $this->readData();
            $this->loaded = true;
        }

        return $this;
    }

    /**
     * Read data from a store or cache
     *
     * @return array
     */
    private function readData()
    {
        if (config('setting.enable_cache')) {
            return cache()->remember(static::CACHE_KEY, now()->addMinutes(config('setting.cache_ttl')), function () {
                return $this->read();
            });
        }

        return $this->read();
    }

    /**
     * Read the data from the store.
     *
     * @return array
     */
    abstract protected function read();

    /**
     * Write the data into the store.
     *
     * @param array $data
     * @return void
     */
    abstract protected function write(array $data);
}