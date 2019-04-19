<?php
/**
 * ympnl
 * Domain: 
 * CCWORLD
 *
 */
namespace App\Http\Middleware;

use Closure;

class VerifyAppIsNotInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
   public function handle($request, Closure $next) {
        $root_dir = realpath(dirname(getcwd()));
        $key =$root_dir.'/smm/key.txt';
        if(!file_exists($key))
        {
                        return redirect('/start');

        }
     return $next($request);
}
}
