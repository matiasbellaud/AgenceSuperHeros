<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            
            $table->integer('idUser');
            $table->foreign('idUser')
            ->references('id')
            ->on('users')
            ->onDelete('restrict')
            ->onUpdate('restrict');

            $table->string('name');
            $table->string('secretIdentity');
            $table->string('gender');
            $table->string('hairColor');
            $table->text('description');

            $table->integer('idHomePlanet');
            $table->foreign('idHomePlanet')
                ->references('id')
                ->on('planets')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->integer('idVehicle');
            $table->foreign('idVehicle')
                ->references('id')
                ->on('vehicles')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('heroes');
    }
};
