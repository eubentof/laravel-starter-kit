<?php

namespace App\Support\Actions;

use RuntimeException;

final class ActionExecutionException extends RuntimeException
{
    public static function forbidden(string $message = 'You are not allowed to perform this action.'): self
    {
        return new self($message, 403);
    }

    public static function notFound(string $resource = 'resource'): self
    {
        return new self("The requested {$resource} was not found.", 404);
    }

    public static function unauthenticated(): self
    {
        return new self('Authentication is required.', 401);
    }
}
