<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hacker_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique()->comment('Mã ID phiên SSH của Cowrie');
            $table->string('ip_address')->comment('IP của Hacker');
            $table->string('username')->nullable()->comment('Tên đăng nhập hacker dùng (vd: root)');
            $table->string('password')->nullable()->comment('Mật khẩu hacker dùng để gõ vào');
            $table->json('commands')->nullable()->comment('Danh sách các lệnh hacker đã gõ (lưu dạng JSON)');
            $table->text('ai_prediction')->nullable()->comment('Kết quả AI dự đoán về phiên này');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hacker_sessions');
    }
};