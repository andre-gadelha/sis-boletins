<?php

namespace App\Repositories;

use App\Http\Requests\UserFormRequest;
use App\Http\Requests\StoreUserFormRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

interface UserRepository
{
    public function simple_search(Request $request): Collection;
}
