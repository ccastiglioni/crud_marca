<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablecategoriaMarca extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_marca', function (Blueprint $table) {
            //$table->id('id_catg');
            $table->Increments('id');
            $table->index(['id']);
            $table->string('nome');
            $table->timestamps();
        });

         
        DB::table('categoria_marca')->insert(
            array( 'nome' => 'Electrolux')
        );
        DB::table('categoria_marca')->insert(
            array( 'nome' => 'Brastemp')
        );
        DB::table('categoria_marca')->insert(
            array( 'nome' => 'Fischer')
        );
        DB::table('categoria_marca')->insert(
            array( 'nome' => 'Samsung')
        );
        DB::table('categoria_marca')->insert(
            array( 'nome' => 'LG')
        );

          
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria_marca');
    }
}
