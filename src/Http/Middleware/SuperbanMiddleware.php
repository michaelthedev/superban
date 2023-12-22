<?php

declare(strict_types=1);

namespace Michaelthedev\Superban\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Michaelthedev\Superban\Services\SuperBanService;

final class SuperbanMiddleware
{
    private SuperBanService $superban;

    public function __construct(SuperBanService $superBanService)
    {
        $this->superban = $superBanService;
    }

    public function handle(
        Request $request,
        Closure $next,
        int $maxRequests,
        int $banAfter,
        int $banPeriod
    ): mixed
    {
        $this->superban
            ->setOptions(
                $this->getIdentifier($request),
                $maxRequests,
                $banAfter,
                $banPeriod
            );

        if ($this->superban->hasBan()) {
            abort(429, 'Too many requests');
        }

        $this->superban
            ->incrementRequests();

        return $next($request);
    }

    private function getIdentifier(Request $request): string
    {
        $identifier = match (config('superban.identifier')) {
            'ip' => $request->ip(),
            'user_id' => $request->user()->id ?? null,
            'user_email' => $request->user()->email ?? null,
            default => null,
        };

        // prevent null identifier, switch to ip
        return $identifier ?? $request->ip();
    }
}
