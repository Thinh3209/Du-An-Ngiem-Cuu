<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShieldFirewall
{
    /**
     * Handle an incoming request and enforce IP-based security protocols.
     */
    public function handle(Request $request, Closure $next)
    {
        $ip = $request->ip();

        // Check if the source IP is flagged in the global blacklist
        if (Cache::has('shield_blocked_ip_' . $ip)) {
            
            // Return a high-severity terminal response for neutralized threats
            return response(
                '<body style="background:#000; color:#ff0000; font-family:monospace; text-align:center; padding-top:10%; overflow:hidden;">
                    <div style="border: 2px solid #ff0000; display: inline-block; padding: 2rem; box-shadow: 0 0 20px #ff0000;">
                        <h1 style="font-size: 3rem; text-shadow: 0 0 10px red; margin: 0;">SHIELD-AI SYSTEM INTERVENTION</h1>
                        <h2 style="letter-spacing: 0.3rem; border-bottom: 1px solid red; padding-bottom: 1rem;">CONNECTION TERMINATED</h2>
                        <p style="font-size: 1.2rem; margin-top: 2rem;">
                            SOURCE IP: [ <b>' . $ip . ' </b> ]
                        </p>
                        <p style="text-transform: uppercase; letter-spacing: 0.1rem;">
                            Access has been permanently revoked due to recognized malicious activity.
                        </p>
                        <div style="margin-top: 3rem; opacity: 0.4; font-size: 0.8rem;">
                            SEC-CORE // PROTOCOL_LEVEL_4 // ENFORCED
                        </div>
                    </div>
                </body>', 403
            );
        }

        return $next($request);
    }
}