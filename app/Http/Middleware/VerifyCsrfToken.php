<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;


use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/caissier-transaction'

    ];
}
