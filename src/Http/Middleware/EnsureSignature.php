<?php

namespace EmekaOrjiani\LinkIO\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSignature
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Retrieve the configured webhook secret from config/linkio.php
        $secret = config('linkio.webhook_secret');

        if (!$secret) {
            abort(500, 'LinkIO webhook secret not configured.');
        }

        // Get the signature from the request headers
        $signatureHeader = $request->header('X-LinkIO-Signature');

        if (!$signatureHeader) {
            abort(401, 'Missing LinkIO signature header.');
        }

        // Compute HMAC hash of the request body using your webhook secret
        $computedSignature = hash_hmac('sha256', $request->getContent(), $secret);

        // Compare the computed signature to the signature sent by LinkIO
        if (!hash_equals($computedSignature, $signatureHeader)) {
            abort(401, 'Invalid LinkIO signature.');
        }

        // If signature matches, proceed with the request
        return $next($request);
    }
}
