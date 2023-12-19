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
        Schema::disableForeignKeyConstraints();
        Schema::create('heros_cities', function (Blueprint $table) {
            $table->id();
            $table->integer('idHero');
            $table->foreign('idHero')
                ->references('id')
                ->on('heros')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->integer('idCity');
            $table->foreign('idCity')
                ->references('id')
                ->on('city')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('heros_cities');
    }
};
