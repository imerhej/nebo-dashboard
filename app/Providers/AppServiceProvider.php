<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Message;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View::share('messages',Message::all());
        View::share('notSeenMessages', DB::table('messages')
                    ->select(DB::raw('count(*) as notSeen, seen, recipient_id'))
                    ->where('seen', '=', 1)
                    ->groupBy('seen', 'recipient_id')
                    ->get());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
