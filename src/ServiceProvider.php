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

    public function register()
    {
        $this->app->singleton('setting', function ($app) {
            return new SettingManager($app);
        });

        $this->app->alias('setting', SettingManager::class);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/settings.php' => config_path('settings.php'),
        ]);
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
