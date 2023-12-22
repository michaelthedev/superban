<?php

declare(strict_types=1);

namespace Michaelthedev\Superban\Services;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

final class SuperBanService
{
    private Repository $cache;

    private int $maxRequests;

    private int $banAfter;

    private int $banPeriod;

    private string $identifier;

    public function __construct()
    {
        $this->cache = Cache::store(config('superban.cache_driver'));
    }

    /**
     * Automatically set the identifier and other config
     *
     * @param string $identifier (ip, user_id, user_email)
     * @param int $maxRequests
     * @param int $banAfter
     * @param int $banPeriod
     * @return void
     */
    public function setOptions(
        string $identifier,
        int $maxRequests,
        int $banAfter,
        int $banPeriod
    ): void
    {
        $this->identifier = "Superban::".$identifier;
        $this->maxRequests = $maxRequests;

        // convert minutes to seconds
        $this->banAfter = $banAfter * 60;
        $this->banPeriod = $banPeriod * 60;
    }

    /**
     * Check if the identifier has been banned
     * @return bool
     * @throws InvalidArgumentException
     */
    public function hasBan(): bool
    {
        return $this->cache
                ->get($this->identifier) === 'banned';
    }

    /**
     * Increment the number requests
     * @return void
     * @throws InvalidArgumentException
     */
    public function incrementRequests(): void
    {
        $requests = $this->cache
            ->get($this->identifier);

        if ($requests === null) {
            $this->cache
                ->put($this->identifier, 1, $this->banAfter);
        } else {
            if ($requests >= $this->maxRequests) {
                $this->ban();
                return;
            }

            $this->cache
                ->increment($this->identifier);
        }
    }

    /**
     * Ban the identifier
     * @return void
     */
    public function ban(): void
    {
        $this->cache
            ->put($this->identifier, 'banned', $this->banPeriod);
    }
}
