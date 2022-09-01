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
        Schema::create('league_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->constrained('leagues');
            $table->string('name');
            $table->string('slug');
            $table->integer('goals')->default(0);
            $table->integer('goals_taken')->default(0);
            $table->enum('phase', ['quarterfinals', 'semifinals', 'final', 'third_place'])->default('quarterfinals');
            $table->enum('status', ['eliminated', 'active', 'champion', 'second', 'third'])->default('active');
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
        Schema::dropIfExists('league_teams');
    }
};
