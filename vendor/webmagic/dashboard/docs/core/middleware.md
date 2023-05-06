You can set up middleware for the routes of the dashboard package.

For this, there are parameter in the **config/dashboard.php** configuration file.

**middleware** - accepts a array value, you can specify a list of middlewares that are available in the project

```php
    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | Can use middleware for sending form
    |
    */
    'middleware' => ['web', 'auth'],
```