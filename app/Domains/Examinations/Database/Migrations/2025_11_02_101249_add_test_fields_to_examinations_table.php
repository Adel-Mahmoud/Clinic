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
        Schema::table('examinations', function (Blueprint $table) {
            $table->enum('test_type', ['lab', 'xray', 'both'])->nullable()->after('symptoms');
            $table->text('test_details')->nullable()->after('test_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examinations', function (Blueprint $table) {
            //
        });
    }
};
