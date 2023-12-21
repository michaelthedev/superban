<br />
<div align="center">
  <h1 align="center">Laravel Superban</h1>

  <p align="center">
    <a href="https://github.com/michaelthedev/superban/issues">Report Bug</a>
    ·
    <a href="https://github.com/michaelthedev/superban/issues">Request Feature</a>
  </p>
</div>

<!-- ABOUT THE PROJECT -->
## About The Project
Superban is a Laravel package that provides a simple and flexible way to ban clients from your API based on their request behavior. It allows you to specify a number of requests after which a client will be banned for a given time interval. The package is built on top of Laravel's built-in rate limiting features and supports different cache drivers.

## Installation

You can install the package via composer:
   ```javascript
   composer require michaelthedev/superban
   ```
After installing the package, you need to register the package's service provider in the `config/app.php` file of your Laravel project:

```php
'providers' => [
    // ...
    Michaelthedev\Superban\SuperbanServiceProvider::class,
],
```

Then, publish the package's configuration file by running the following command:

```php
php artisan vendor:publish --provider="Michaelthedev\Superban\SuperbanServiceProvider"
```

## Configuration

The package's configuration file is located at `config/superban.php`. Here you can specify the cache driver to use (Redis, Database, etc.) and the parameters for banning clients.

```php
return [
    'cache_driver' => env('SUPERBAN_CACHE_DRIVER', env('CACHE_DRIVER', 'file')),
    'requests_before_ban' => env('SUPERBAN_REQUESTS_BEFORE_BAN', 200),
    'ban_after' => env('SUPERBAN_BAN_AFTER', 2),
    'ban_length' => env('SUPERBAN_BAN_LENGTH', 1440),
];
```

## Usage

After installing and configuring the package, you can use the `superban` middleware on your routes like so:

```php
Route::middleware(['superban:200,2,1440'])->group(function () {
   Route::post('/thisroute', function () {
       // ...
   });

   Route::post('anotherroute', function () {
       // ...
   });
});
```

In the above example, `200` is the number of requests, `2` is the amount of minutes for the period of time the number of requests can happen, and `1440` is the amount of minutes for which the user is banned for.

The `superban` middleware takes into consideration the ability to ban by user id, IP address and email. You can apply it either for specific or all routes.

## License

The Superban package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch
3. Commit your Changes
4. Push to the Branch
5. Open a Pull Request
