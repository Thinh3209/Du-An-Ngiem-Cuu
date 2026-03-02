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
    Schema::create('web_shell_logs', function (Blueprint $table) {
        $table->id();
        $table->string('file_path');
        $table->string('file_name');
        $table->string('detected_type'); // Ví dụ: PHP Shell, Malicious Content
        $table->string('status')->default('Quarantined'); // Chế độ cách ly
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_shell_logs');
    }
};
