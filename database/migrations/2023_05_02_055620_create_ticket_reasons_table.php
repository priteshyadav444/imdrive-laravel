<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_reasons', function (Blueprint $table) {
            $table->id();
            $table->string("name", 60);
            $table->enum("status", ['active', 'inactive']);
            $table->unsignedBigInteger("created_by_user_id");
            $table->foreign("created_by_user_id")->references("id")->on("users")->onDelete("cascade");;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_reasons');
    }
};