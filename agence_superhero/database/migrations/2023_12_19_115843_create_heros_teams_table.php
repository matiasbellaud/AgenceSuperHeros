<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('heros_teams', function (Blueprint $table) {
            $table->id();
            $table->integer('idHero');
            $table->foreign('idHero')
                ->references('id')
                ->on('heros')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->integer('idTeam');
            $table->foreign('idTeam')
                ->references('id')
                ->on('teams')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('heros_teams');
    }
};
