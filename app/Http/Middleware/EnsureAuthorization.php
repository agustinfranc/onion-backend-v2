<?php

namespace App\Http\Middleware;

use App\Repositories\CommerceRepository;
use Closure;
use Illuminate\Http\Request;

class EnsureAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->admin) {
            return $next($request);
        }

        $repository = new CommerceRepository;
        $userCommerces = $repository->getAll([], $request->user());

        $commerce = $request->commerce;

        if ($request->product) {
            $commerce = $request->product->commerce;
        }

        if ($commerce && !$userCommerces->contains($commerce->id)) {
            //! Reemplazar por exception
            abort(401, 'User has no permission to access this commerce');
        }

        return $next($request);
    }
}
