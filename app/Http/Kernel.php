<php

protected $routeMiddleware = [
    // ... otros middlewares
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];