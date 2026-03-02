<?php

namespace App\Services;

use App\Models\WebShellLog;
use Illuminate\Support\Facades\File;

class ShellHunterService
{
    protected $dangerTokens = [
        'shell_exec',
        'base64_decode',
        'eval(',
        'system(',
        'passthru(',
        'exec('
    ];

    public function scanDirectory($path)
    {
        if (!File::exists($path)) {
            return;
        }

        $files = File::allFiles($path);

        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                $filePath = $file->getRealPath();

                // BẢN VÁ LỖI: Nếu file đã bị khóa quyền (không thể đọc), thì bỏ qua luôn
                if (!is_readable($filePath)) {
                    continue;
                }

                $content = file_get_contents($filePath);
                $fileName = $file->getFilename();

                foreach ($this->dangerTokens as $token) {
                    if (strpos($content, $token) !== false) {
                        
                        // 1. Khóa file ngay lập tức
                        chmod($filePath, 000);

                        // 2. Lưu lịch sử vào Database
                        WebShellLog::updateOrCreate(
                            ['file_path' => $filePath],
                            [
                                'file_name' => $fileName,
                                'detected_type' => 'Chứa hàm: ' . $token,
                                'status' => 'Quarantined'
                            ]
                        );
                        
                        break; 
                    }
                }
            }
        }
    }
}