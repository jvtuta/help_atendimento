<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nome_usuario')->unique();
            $table->string('nivel_users',20)->nullable();
            $table->string('image_perfil_urn')->nullable();
            $table->boolean('active')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('id_departamento');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('id_departamento')->references('id')->on('departamentos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
