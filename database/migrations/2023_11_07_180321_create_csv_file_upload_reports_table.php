<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('csv_file_upload_reports', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->nullable();
            $table->integer('total_data')->nullable();
            $table->integer('total_store')->nullable();
            $table->integer('total_duplicate')->nullable();
            $table->integer('total_invalid')->nullable();
            $table->integer('total_incomplete')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('csv_file_upload_reports');
    }
};
