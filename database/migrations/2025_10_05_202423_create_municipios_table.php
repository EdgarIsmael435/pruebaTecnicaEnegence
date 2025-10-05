<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->bigIncrements('id_municipio');
            $table->unsignedBigInteger('id_estado');
            $table->string('nombre_municipio');
            $table->timestamps();

            $table->foreign('id_estado')->references('id_estado')->on('estados')->onDelete('cascade');
            $table->unique(['id_estado', 'nombre_municipio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipios');
    }
};
