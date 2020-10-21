<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        DB::listen(function ($query) {

            foreach ($query->bindings as $i => $binding) {
                if ($binding instanceof \DateTime) {
                    $query->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                } else {
                    if (is_string($binding)) {
                        $query->bindings[$i] = "'{$binding}'";
                    }
                }
            }

            $sql = str_replace(array('%', '?'), array('%%', '%s'), $query->sql);
            $sql = vsprintf($sql, $query->bindings) . ' 耗时：' . $query->time . 'ms';

            Log::channel('mysql')->debug($sql);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
