<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Cache;
use Michaelthedev\Superban\Services\SuperBanService;

test('check if a client is banned', function () {
    $service = new SuperBanService();
    $service->setOptions('ip', 20, 2, 1);

    Cache::shouldReceive('get');

    expect($service->hasBan())->toBeFalse();
});
