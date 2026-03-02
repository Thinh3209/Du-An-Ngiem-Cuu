<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('intrusion_logs', function (Blueprint $table) {
        $table->id();
        $table->string('ip_address')->nullable();
        $table->string('username_attempt')->nullable();
        $table->string('password_attempt')->nullable();
        $table->string('action_type')->nullable();
        
        // 2 CỘT MỚI ĐỂ LÀM AI ANALYSIS VÀ DASHBOARD
        $table->string('attack_type')->nullable(); 
        $table->integer('risk_score')->default(0); 
        $table->string('status')->default('Pending');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intrusion_logs');
    }
};
