<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class DomainServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $domainsPath = app_path('Domains');

        if (! File::exists($domainsPath)) {
            return;
        }

        foreach (File::directories($domainsPath) as $domainPath) {
            $domainName = basename($domainPath);

            if (File::exists("$domainPath/Routes/web.php")) {
                $this->loadRoutesFrom("$domainPath/Routes/web.php");
            }

            if (File::exists("$domainPath/Routes/admin.php")) {
                $this->loadRoutesFrom("$domainPath/Routes/admin.php");
            }

            if (File::isDirectory("$domainPath/Views")) {
                $this->loadViewsFrom("$domainPath/Views", strtolower($domainName));
            }

            if (File::isDirectory("$domainPath/Database/Migrations")) {
                $this->loadMigrationsFrom("$domainPath/Database/Migrations");
            }
        }
    }
}
