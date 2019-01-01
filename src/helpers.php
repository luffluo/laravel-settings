<?php

if (! function_exists('setting')) {
    /**
     * Get / set the specified setting value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param string|array $key
     * @param mixed        $default
     *
     * @return \Luffluo\LaravelSettings\SettingManager|mixed
     */
    function setting($key = null, $default = null)
    {
        /* @var \Luffluo\LaravelSettings\SettingManager $setting */
        $setting = app('setting');

        if (is_null($key)) {
            return $setting;
        }

        if (is_array($key)) {
            return $setting->set($key);
        }

        return $setting->get($key, $default);
    }
}
