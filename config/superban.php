<?php

return [
    'cache_driver' => env('SUPERBAN_CACHE_DRIVER', env('CACHE_DRIVER', 'file')),
    'requests_before_ban' => env('SUPERBAN_REQUESTS_BEFORE_BAN', 200),
    'ban_after' => env('SUPERBAN_BAN_AFTER', 2),
    'ban_length' => env('SUPERBAN_BAN_LENGTH', 1440),
];
