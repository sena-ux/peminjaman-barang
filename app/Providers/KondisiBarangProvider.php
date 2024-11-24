<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class KondisiBarangProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $conditions = [
            'bagus' => 'Bagus',
            'rusak' => 'Rusak',
            'baru' => 'Baru',
            'kosong' => 'Kosong',
            'layak' => 'Masih Layak Di Pakai',
        ];
        view()->share('setKondisi', $conditions);
    }
}
