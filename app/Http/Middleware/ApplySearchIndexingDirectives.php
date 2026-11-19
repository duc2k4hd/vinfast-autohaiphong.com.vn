<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplySearchIndexingDirectives
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hasQueryParameters = $request->query->count() > 0;
        $isAdminRequest = $this->isAdminRequest($request);
        $isPrivateUtilityRequest = $this->isPrivateUtilityRequest($request);
        $isApiRequest = $request->is('api', 'api/*');

        $request->attributes->set('seo_has_query_parameters', $hasQueryParameters);
        $request->attributes->set(
            'seo_robots',
            ($isAdminRequest || $isPrivateUtilityRequest || $isApiRequest)
                ? 'noindex, nofollow'
                : ($hasQueryParameters ? 'noindex, follow' : null)
        );

        $response = $next($request);

        if ($response->getStatusCode() >= 400 || $isAdminRequest || $isPrivateUtilityRequest || $isApiRequest) {
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow');

            return $response;
        }

        if ($hasQueryParameters) {
            $response->headers->set('X-Robots-Tag', 'noindex, follow');
        }

        return $response;
    }

    private function isAdminRequest(Request $request): bool
    {
        return $request->is('admin', 'admin/*');
    }

    private function isPrivateUtilityRequest(Request $request): bool
    {
        return $request->is(
            'dat-coc-ngay',
            'gio-hang',
            'thanh-toan',
            'dat-hang-thanh-cong/*'
        );
    }
}
