<?php

namespace App\Providers;

use App\Models\PurchaseInvoice;
use App\Models\PurchaseQuotation;
use App\Observers\PurchaseInvoiceObserver;
use App\Observers\PurchaseQuotationObserver;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        PurchaseQuotation::observe(PurchaseQuotationObserver::class);
        PurchaseInvoice::observe(PurchaseInvoiceObserver::class);

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar','en']); // also accepts a closure
        });

    }
}
