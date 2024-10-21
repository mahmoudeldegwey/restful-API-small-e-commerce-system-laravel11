<?php 
namespace App\Filters;

use Closure;

class PriceRangeFilter
{
    public function handle($request, Closure $next)
    {
        if (request()->filled('min_price') && request()->filled('max_price')) {

            return $next($request)->where('price', '>=' ,request()->min_price)->where('price','<=' ,request()->max_price);
        
        }elseif(request()->filled('min_price')){
            
            return $next($request)->where('price', '>=' ,request()->min_price);
        
        }else if(request()->filled('max_price')){
        
            return $next($request)->where('price', '<=' ,request()->max_price);
        
        }

        return $next($request);

    }
}