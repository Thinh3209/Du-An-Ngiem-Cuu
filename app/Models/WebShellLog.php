<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebShellLog extends Model
{
    
   protected $fillable = ['file_path', 'file_name', 'detected_type', 'status'];
}