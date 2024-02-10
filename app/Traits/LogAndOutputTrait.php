<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

/**
 * Trait para guardar logs en ficheros y salida en consola
 */
trait LogAndOutputTrait
{
    protected function logAndOutput(string $message, string $level = 'debug')
    {
        Log::$level($message);
        $this->line($message);
    }

    protected function log(string $message, string $level = 'debug')
    {
        Log::$level($message);
    }
}
