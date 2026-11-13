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
        Schema::create('speakers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 180);
            $table->string('email', 180)->unique();
            $table->string('phone', 40);
            $table->enum('role', [
                'Keynote Speaker', 
                'Workshop Facilitator', 
                'Panelist', 
                'Guest Lecturer'
            ]);
            $table->enum('status', [
                'Verified', 
                'Pending Review', 
                'On Leave'
            ]);
            $table->string('current_institution', 180);
            $table->string('primary_domain', 180);
            $table->text('bio')->nullable();
            $table->text('skills')->nullable();
            $table->string('portfolio_url', 255)->nullable();
            
            // Karena model Anda menggunakan const UPDATED_AT = null, 
            // kita hanya butuh created_at (atau biarkan timestamps() tetapi updated_at akan dibiarkan null oleh Eloquent)
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speakers');
    }
};