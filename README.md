<p align="center"><a href="https://laravel.com" target="_blank"><img height="300" width="500" src="https://cloud.githubusercontent.com/assets/1801923/9915273/119b9350-5cae-11e5-850b-c941cac60b32.png"/></a></p>


## About JWT


Laravel JWT (JSON Web Token) is a popular package used in Laravel applications to handle token-based authentication. It provides a simple and secure way to authenticate and authorize users by issuing and verifying JSON Web Tokens.

The primary package used for implementing JWT in Laravel is called "tymon/jwt-auth." This package integrates seamlessly with Laravel's authentication system, allowing you to generate JWTs for authenticated users and protect routes based on token authentication.

- [get official docs](https://jwt-auth.readthedocs.io/en/develop).

## JWT Installation
1. Run the following command to pull in the latest version:</br>
        composer require tymon/jwt-auth
2. Add the service provider to the providers array in the config/app.php config file as follows:
        'providers' => [
        Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
        ],
3.Run the following command to publish the package config file:
        php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
