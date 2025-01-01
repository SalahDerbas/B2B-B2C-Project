<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    Laravel\Passport\PassportServiceProvider::class,
    Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class,

    App\Providers\SourceServiceProvider::class,
    App\Providers\PaymentServiceProvider::class,

];
