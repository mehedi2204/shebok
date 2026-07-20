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
        Schema::table('provider_profiles', function (Blueprint $table) {
            $table->string('profession')->nullable();
            $table->text('address')->nullable();
            $table->string('nid_path')->nullable();
            $table->string('license_path')->nullable();
            $table->string('certificate_path')->nullable();
            $table->string('experience_path')->nullable();
            $table->json('additional_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provider_profiles', function (Blueprint $table) {
            //
        });
    }
};
