<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Listener каждого SQL-запроса. Нужно чтобы узнать сколько времени выполняется запрос
         *
         */
        DB::listen(function ($query) {
            $query->sql; // выполненная sql-строка
            $query->bindings; // параметры, переданные в запрос (то, что подменяет '?' в sql-строке)
            $query->time; // время выполнения запроса
        });
    }
}
