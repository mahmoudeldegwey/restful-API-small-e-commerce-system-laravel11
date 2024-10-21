<?php 
namespace App\Filters;

use Closure;

class ProductNameFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('name')) {
            return $next($request)->where('name', request()->name);
        }

        return $next($request);

    }
}

