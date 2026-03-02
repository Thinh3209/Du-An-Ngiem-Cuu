<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebShellLog extends Model
{
    // Thêm các cột này vào fillable để cho phép ghi dữ liệu
   protected $fillable = ['file_path', 'file_name', 'detected_type', 'status'];
}