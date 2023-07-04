<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=>'Administrador',
            'email'=>'administrador@sef.eb.mil.br',
            'password'=>bcrypt('4Dm1n15tr4d0r'),
            'status'=>'actived',
            'profile'=>'administrator',
        ]);
    }
}
