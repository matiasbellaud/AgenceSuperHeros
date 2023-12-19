<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('heros', function (Blueprint $table) {
            $table->id();
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

            $table->integer('idSuperPower');
            $table->foreign('idSuperPower')
                ->references('id')
                ->on('superPowers')
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
        Schema::dropIfExists('heros');
    }
};
