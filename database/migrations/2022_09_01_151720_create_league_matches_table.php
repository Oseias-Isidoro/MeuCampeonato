<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained('leagues');
            $table->foreignId('team_home_id')->constrained('league_teams');
            $table->foreignId('team_outside_id')->constrained('league_teams');
            $table->integer('team_home_goals')->default(0);
            $table->integer('team_outside_goals')->default(0);
            $table->foreignId('winning_team_id')->nullable()->constrained('league_teams');
            $table->enum('phase', ['quarterfinals', 'semifinals', 'final', 'third_place'])->default('quarterfinals');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('league_matches');
    }
};
