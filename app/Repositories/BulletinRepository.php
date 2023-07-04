<?php

namespace App\Repositories;

use App\Http\Requests\BulletinFormRequest;
use App\Http\Requests\StoreBulletinFormRequest;
use Illuminate\Http\Request;
use App\Models\Bulletin;
use Illuminate\Database\Eloquent\Collection;

interface BulletinRepository
{
    public function add(StoreBulletinFormRequest $request): Bulletin;
    public function search(BulletinFormRequest $request = null): Collection;
    public function simple_search(Request $request): Collection;
}
