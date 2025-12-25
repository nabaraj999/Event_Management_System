<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SeoPage;

class ViewServiceProvider extends ServiceProvider
{
   public function boot()
{
   View::composer('*', function ($view) {
        if (!isset($view->getData()['pageSeo'])) {
            $routeName = request()->route()?->getName() ?? 'home';
            $seo = \App\Models\SeoPage::getForPage($routeName);
            $view->with('pageSeo', $seo);
        }
    });
}
}
