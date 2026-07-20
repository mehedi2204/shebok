<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('provider_profiles', function (Blueprint $table) {
            $table->foreignId('country_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('division_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->foreignId('district_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->string('thana_upazila')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('provider_profiles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('country_id');
            $table->dropConstrainedForeignId('division_id');
            $table->dropConstrainedForeignId('district_id');
            $table->dropColumn('thana_upazila');
        });
    }
};
