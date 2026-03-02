<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\IntrusionLog;

class WebShellShield
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Danh sách các đuôi file cấm và lệnh nguy hiểm
        $dangerousExtensions = ['php', 'phtml', 'sh', 'exe', 'bat', 'cmd'];
        $dangerousSignatures = ['<?php', 'eval(', 'system(', 'shell_exec(', 'base64_decode('];

        // 2. Quét toàn bộ file được tải lên
        foreach ($request->allFiles() as $file) {
            $extension = strtolower($file->getClientOriginalExtension());
            $content = file_get_contents($file->getRealPath());

            $isDangerous = false;

            // Kiểm tra đuôi file
            if (in_array($extension, $dangerousExtensions)) {
                $isDangerous = true;
            }

            // Kiểm tra nội dung (Chữ ký mã độc)
            foreach ($dangerousSignatures as $sig) {
                if (strpos($content, $sig) !== false) {
                    $isDangerous = true;
                    break;
                }
            }

            // 3. Xử lý tiêu diệt và Báo động
            if ($isDangerous) {
                // Đẩy dữ liệu vào Lớp 2 (Dashboard) và tự động kích hoạt Lớp 5 (Telegram)
                IntrusionLog::create([
                    'ip_address' => $request->ip(),
                    'attack_type' => 'Exploit',
                    'action_type' => 'Upload Web Shell',
                    'risk_score' => 95 // Điểm cực cao để tự động khóa
                ]);

                // Đuổi cổ kẻ tấn công
                return response()->json([
                    'error' => 'SHIELD-AI ALERT: Phat hien ma doc! IP cua ban da bi ghi nhan va khoa.'
                ], 403);
            }
        }

        return $next($request);
    }
}