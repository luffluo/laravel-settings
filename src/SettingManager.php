<?php

namespace Luffluo\LaravelSettings;

use Illuminate\Support\Manager;
use Luffluo\LaravelSettings\Stores\JsonStore;

class SettingManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->app['config']->get('settings.store', 'json');
    }

    public function createJsonDriver()
    {
        return new JsonStore($this->app['files'], $this->app['config']['settings.path']);
    }
}
