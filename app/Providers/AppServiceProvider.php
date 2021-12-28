<?php

namespace App\Providers;

use App\Models\Link;
use App\Observers\LinkObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /** @noinspection ReturnTypeCanBeDeclaredInspection */
    public function register()
    {
        Link::observe(LinkObserver::class);
    }
}
