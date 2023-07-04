<?php

namespace App\Providers;

use App\Repositories\EloquentBulletinRepository;
use App\Repositories\BulletinRepository;
use Illuminate\Support\ServiceProvider;

class BulletinRepositoryProvider extends ServiceProvider
{
    public array $bindings = [
        BulletinRepository::class => EloquentBulletinRepository::class
    ];
}
