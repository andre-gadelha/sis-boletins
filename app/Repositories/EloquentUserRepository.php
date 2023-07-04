<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class EloquentUserRepository implements UserRepository
{    
    public function simple_search(Request $request): Collection
    {
        return User::query()->where('name','LIKE','%'.$request->words_to_filter.'%')->get();
    }
}
