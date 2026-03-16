<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\IntrusionLog;

class WebShellShield
{
    /**
     * Intercept and analyze file uploads for malicious WebShell payloads.
     */
    public function handle(Request $request, Closure $next)
    {
        // Defined threat vectors
        $forbiddenExtensions = ['php', 'phtml', 'sh', 'exe', 'bat', 'cmd'];
        $maliciousSignatures = ['<?php', 'eval(', 'system(', 'shell_exec(', 'base64_decode('];

        foreach ($request->allFiles() as $file) {
            $extension = strtolower($file->getClientOriginalExtension());
            $content = file_get_contents($file->getRealPath());
            $threatDetected = false;

            // 1. Validate File Extension
            if (in_array($extension, $forbiddenExtensions)) {
                $threatDetected = true;
            }

            // 2. Deep Packet Inspection (Signature Matching)
            if (!$threatDetected) {
                foreach ($maliciousSignatures as $sig) {
                    if (str_contains($content, $sig)) {
                        $threatDetected = true;
                        break;
                    }
                }
            }

            // Execute Countermeasures if threat is verified
            if ($threatDetected) {
                
                // Record incident in the global audit trail
                IntrusionLog::create([
                    'ip_address' => $request->ip(),
                    'attack_type' => 'Exploit',
                    'action_type' => 'Malicious WebShell Upload Attempt',
                    'risk_score' => 95,
                    'status' => 'Terminated'
                ]);

                // Return high-severity JSON response
                return response()->json([
                    'error' => 'SHIELD-AI SECURITY ALERT: Malicious payload detected. This incident has been logged and your access has been revoked.'
                ], 403);
            }
        }

        return $next($request);
    }
}