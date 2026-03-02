<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('intrusion_logs', function (Blueprint $table) {
            // Thêm 2 cột để lưu tọa độ hacker sinh ra từ code của bạn
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('intrusion_logs', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};