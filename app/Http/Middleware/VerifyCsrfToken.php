<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // TNS Card: the landing page sets no session cookie, so the public lead
        // form cannot carry a CSRF token. It is protected by a honeypot, a timing
        // check, a same-origin check and rate limiting instead (LeadController).
        'leads',
    ];
}
