<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('heros_gadgets', function (Blueprint $table) {
            $table->id();
            $table->integer('idHero');
            $table->foreign('idHero')
                ->references('id')
                ->on('heros')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->integer('idGadget');
            $table->foreign('idGadget')
                ->references('id')
                ->on('gadgets')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('heros_gadgets');
    }
};
