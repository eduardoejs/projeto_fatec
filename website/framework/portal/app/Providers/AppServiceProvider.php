<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        Blade::component('componentes.modal', 'modal_component');
        Blade::component('componentes.card_aviso', 'card_aviso_component');
        Blade::component('componentes.alert', 'alert_component');
        Blade::component('componentes.form', 'form_component');
        Blade::component('componentes.breadcrumb', 'breadcrumb_component');
        Blade::component('componentes.table', 'table_component');
        Blade::component('componentes.pagina', 'page_component');
        Blade::component('componentes.body_page', 'bodypage_component');
        Blade::component('componentes.page_header', 'pageheader_component');
        Blade::component('componentes.busca', 'busca_component');
        Blade::component('componentes.card_menu', 'card_menu_component');
    }
}
