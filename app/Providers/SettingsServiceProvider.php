<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Domains\Settings\Repositories\SettingEntityRepository;

class SettingsServiceProvider extends ServiceProvider
{
    public function boot(SettingEntityRepository $repository)
    {
        $settings = cache()->rememberForever('settings', function () use ($repository) {
            return $repository->all()->first()?->toArray() ?? [];
        });

        Config::set('settings', $settings);
    }
}
