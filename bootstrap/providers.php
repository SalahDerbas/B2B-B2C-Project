<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    Laravel\Passport\PassportServiceProvider::class,
    Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class,
    App\Providers\SourceServiceProvider::class,
    App\Providers\PaymentServiceProvider::class,
    Yajra\DataTables\DataTablesServiceProvider::class,
    Yajra\DataTables\EditorServiceProvider::class,   // if using editor
    Yajra\DataTables\ExportServiceProvider::class,   // if using export
    Laravel\Sail\SailServiceProvider::class,


];
