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
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('form')->nullable(); 
            $table->string('strength')->nullable();
            $table->string('generic_name')->nullable(); 
            $table->string('manufacturer')->nullable(); 
            $table->string('barcode')->nullable(); 
            $table->string('default_dosage')->nullable(); 
            $table->string('default_instructions')->nullable(); 
            $table->boolean('is_active')->default(true); 
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drugs');
    }
};
