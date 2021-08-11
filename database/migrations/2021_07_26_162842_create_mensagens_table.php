<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensagensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensagens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('de_user_id');
            $table->unsignedBigInteger('para_user_id');
            $table->string('desc_mensagem')->nullable();
            // $table->boolean('ativo');
            $table->string('urn_arquivo')->nullable();
            $table->timestamps();
            // user_id->remetente
            // 
            $table->foreign('de_user_id')->references('id')->on('users');
            $table->foreign('para_user_id')->references('id')->on('users');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mensagens');
    }
}
