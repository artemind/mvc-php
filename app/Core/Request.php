<?php

namespace App\Core;

class Request
{
    public static function expectsJsonResponse(): bool
    {
        return isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json');
    }
}