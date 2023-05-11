<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deliverable_project', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("project_id");
            $table->foreign("project_id")->references("id")->on("projects");
            $table->unsignedBigInteger("deliverable_id");
            $table->foreign("deliverable_id")->references("id")->on("deliverables");
            $table->date("created_at");
            $table->unique(['project_id', 'deliverable_id']);
        });

        // DB::unprepared('ALTER TABLE `deliverable_project` ADD unique(project_id, deliverable_id)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_deliverables');
    }
};
