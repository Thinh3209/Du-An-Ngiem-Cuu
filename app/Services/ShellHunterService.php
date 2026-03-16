<?php

namespace App\App\Services;

use App\Models\WebShellLog;
use Illuminate\Support\Facades\Log;

class ShellHunterService
{
    /**
     * Regex pattern to identify high-risk execution functions and malicious signatures.
     */
    protected $threatPattern = '/(eval|system|shell_exec|exec|passthru|base64_decode)\s*\(/i';

    /**
     * Scan a specific directory for PHP-based WebShell signatures.
     */
    public function scanDirectory($directoryPath)
    {
        // 1. Validate target directory integrity
        if (!is_dir($directoryPath)) {
            Log::warning("SHIELD-AI: Target path invalid or inaccessible: " . $directoryPath);
            return;
        }

        // 2. Identify PHP source files via glob pattern
        $files = glob(rtrim($directoryPath, '/') . '/*.php');

        if (!$files) {
            return;
        }

        foreach ($files as $filePath) {
            $fileName = basename($filePath);

            // Skip if the file is already neutralized (chmod 000) or unreadable
            if (!is_readable($filePath)) continue;

            // Retrieve source content; suppress errors for corrupted files
            $content = @file_get_contents($filePath);
            if (empty($content)) continue;

            // 3. Signature analysis for threat vectors
            if (preg_match($this->threatPattern, $content, $matches)) {
                $detectedToken = strtoupper($matches[1]);

                // THREAT NEUTRALIZATION: Revoke all file permissions (chmod 000)
                @chmod($filePath, 000);

                // RECORD INCIDENT: Update security audit logs
                WebShellLog::updateOrCreate(
                    ['file_path' => $filePath],
                    [
                        'file_name'     => $fileName,
                        'detected_type' => 'SIGNATURE_MATCH.' . $detectedToken,
                        'status'        => 'Isolated',
                        'created_at'    => now()
                    ]
                );

                Log::info("SHIELD-AI: Malicious payload neutralized and isolated: " . $fileName);
            }
        }
    }
}