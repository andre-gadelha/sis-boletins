<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY profile ENUM('user', 'administrator', 'adminBoletins', 'adminUsuarios') NOT NULL DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Em caso de rollback, voltar os valores originais'
        DB::statement("ALTER TABLE users MODIFY profile ENUM('administrator', 'user') NOT NULL DEFAULT 'user'");
    }
};
