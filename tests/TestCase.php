<?php

declare(strict_types=1);

namespace Michaelthedev\Superban\Tests;

use Michaelthedev\Superban\SuperbanServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SuperbanServiceProvider::class,
        ];
    }
}
