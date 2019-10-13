<h1 align="center">Laravel Settings</h1>

## Installing

```shell
$ composer require luffluo/laravel-settings:~1.1
```

## Usage

Add the middleware 'Luffluo\\LaravelSettings\\SaveMiddleware' to your middleware for Auto save.

```php
setting('key', 'default') // get

setting(['key' => 'value'])->save() // set

setting()->all(); // get all

setting()->forget('key')->save() // forget

setting()->forgetAll()->save() // forget all
```

## License

MIT