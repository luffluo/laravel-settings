<?php

namespace Luffluo\LaravelSettings;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * 是否延时加载提供器
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/setting.php' => config_path('setting.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/setting.php', 'setting');

        $this->app->singleton('setting', function ($app) {
            return new SettingManager($app);
        });

        $this->app->alias('setting', SettingManager::class);
    }

    /**
     * 获取提供器提供的服务。
     *
     * @return array
     */
    public function provides()
    {
        return [
            'setting',
            SettingManager::class,
        ];
    }
}
