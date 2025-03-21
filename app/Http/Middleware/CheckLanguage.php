<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $languages = config('app.languages');
        array_keys($languages);
        if($request->hasHeader('lang')&&in_array($request->header('lang'),$languages) ){
            app()->setlocale($request->getHeader('lang'));
        }
        return $next($request);
    }
}
