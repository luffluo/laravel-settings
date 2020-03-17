<h1 align="center">Laravel Settings</h1>

## Installing

```shell
$ composer require luffluo/laravel-settings:~1.2
```

## 如果要自定义配置，执行下面的命令发布配置文件
```shell
php artisan vendor:publish --provider="Luffluo\LaravelSettings\ServiceProvider" --tag="config"
```

## Usage

Add the middleware 'Luffluo\\LaravelSettings\\SaveMiddleware' to your middleware for Auto save.

```php
<?php

setting('key', 'default'); // get

setting(['key' => 'value'])->save(); // set

setting()->all(); // get all

setting()->forget('key')->save(); // forget

setting()->forgetAll()->save(); // forget all
```

## License

MIT