<?php

namespace Luffluo\LaravelSettings;

class SaveMiddleware
{
    /**
     * @var SettingManager
     */
    protected $settings;

    public function __construct(SettingManager $settings)
    {
        $this->settings = $settings;
    }

    public function handle($request, \Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $this->settings->save();
    }
}
