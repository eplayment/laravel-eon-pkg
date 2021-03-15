<?php

namespace Eplayment\Wallet;

use Illuminate\Support\ServiceProvider;

class WalletServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/wallet.php' => config_path('wallet.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind('Wallet', 'Eplayment\Wallet\Wallet');
    }
}
