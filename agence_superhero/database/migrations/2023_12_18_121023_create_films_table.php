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
        Schema::create('heros', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('secretIdentity');
            $table->string('gender');
            $table->string('hairColor');
            $table->text('description');
            $table->int('idHomePlanet');
            $table->foreign('idHomePlanet')
                ->references('id')
                ->on('planets')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->intd('idSuperPower');
            $table->foreign('idSuperPower')
                ->references('id')
                ->on('superPowers')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->int('idVehicle');
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

    // Table planets

    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planets');
    }


    // Table superPowers

    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('superPowers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('superPowers');
    }

    // Table vehicles

    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('type');
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }

    // Table powers

    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('powers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('powers');
    }

    // Table herosPowers

    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('herosPowers', function (Blueprint $table) {
            $table->id();
            $table->int('idHero');
            $table->foreign('idHero')
                ->references('id')
                ->on('heros')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->int('idPower');
            $table->foreign('idPower')
                ->references('id')
                ->on('powers')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('herosPowers');
    }

    // Table city

    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('city', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('city');
    }

    // Table herosCity

    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('herosCity', function (Blueprint $table) {
            $table->id();
            $table->int('idHero');
            $table->foreign('idHero')
                ->references('id')
                ->on('heros')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->int('idCity');
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
        Schema::dropIfExists('herosCity');
    }

    // Table gadgets

    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('gadgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gadgets');
    }

    // Table herosGadgets

    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('herosGadgets', function (Blueprint $table) {
            $table->id();
            $table->int('idHero');
            $table->foreign('idHero')
                ->references('id')
                ->on('heros')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->int('idGadget');
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
        Schema::dropIfExists('herosGadgets');
    }

    // Table teams

    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }

    // Table herosTeams

    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('herosTeams', function (Blueprint $table) {
            $table->id();
            $table->int('idHero');
            $table->foreign('idHero')
                ->references('id')
                ->on('heros')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->int('idTeam');
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
        Schema::dropIfExists('herosTeams');
    }
};
