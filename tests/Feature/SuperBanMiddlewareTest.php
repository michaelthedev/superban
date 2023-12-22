<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Michaelthedev\Superban\Http\Middleware\SuperbanMiddleware;

it('bans user after exceeding rate limit', function () {

    Route::middleware([SuperbanMiddleware::class . ':2,1,1'])->get('/path', function () {
        return 'OK';
    });

    // Lets for the rate limiting to kick in
    $firstRun = $this->withMiddleware(SuperbanMiddleware::class, '2,1,1')->get('/path');
    $secondRun = $this->withMiddleware(SuperbanMiddleware::class, '2,1,1')->get('/path');

    // We're expecting a 429 response here
    $thirdRun = $this->withMiddleware(SuperbanMiddleware::class, '2,1,1')->get('/path');

    expect($firstRun->getStatusCode())->toBe(200);
    expect($secondRun->getStatusCode())->toBe(200);
    expect($thirdRun->getStatusCode())->toBe(429);
});
