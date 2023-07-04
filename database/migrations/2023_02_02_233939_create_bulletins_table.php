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
        Schema::create('bulletins', function (Blueprint $table) {
            $table->id();
            //inicio meus campos
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';

            $table->string('name_of_file', 150)->nullable();
            $table->longText('original_text')->nullable();
            $table->longText('text_without_formatation')->fullText()->nullable();
            $table->string('path_of_file', 150)->nullable();
            //$table->date('date_of_publish');
            $table->dateTime('date_of_publish');
                        
            //fim meus campos
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulletins');
    }
};
