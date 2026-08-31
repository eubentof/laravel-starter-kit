<?php

namespace App\Support\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use ReflectionClass;
use Spatie\LaravelData\Data;

abstract class Action extends Data
{
    final public function validateAction(): void
    {
        static::validate($this->toArray());
    }

    final public function execute(?User $executor = null): mixed
    {
        $executor ??= Auth::user();

        if (! $executor instanceof User) {
            throw ActionExecutionException::unauthenticated();
        }

        return $this->invokeHandler($this->handler(), [$executor, $this]);
    }

    final public function executeAsGuest(): mixed
    {
        $handler = $this->handler();

        if (! $handler instanceof GuestActionHandler) {
            throw new \LogicException(static::class.' does not support guest execution.');
        }

        return $this->invokeHandler($handler, [$this]);
    }

    final public function dispatch(?User $executor = null): void
    {
        $executor ??= Auth::user();

        if (! $executor instanceof User) {
            throw ActionExecutionException::unauthenticated();
        }

        ExecuteActionJob::dispatch($this, $executor);
    }

    private function handler(): ActionHandler
    {
        $attributes = (new ReflectionClass($this))->getAttributes(HandledBy::class);

        if ($attributes === []) {
            throw new \LogicException(static::class.' must declare #[HandledBy].');
        }

        return app($attributes[0]->newInstance()->handler);
    }

    /** @param list<Action|User> $arguments */
    private function invokeHandler(ActionHandler $handler, array $arguments): mixed
    {
        if (! is_callable($handler)) {
            throw new \LogicException($handler::class.' must define a public __invoke method.');
        }

        $this->validateAction();

        return DB::transaction(fn (): mixed => $handler(...$arguments));
    }

    /** @param array<string, mixed> $data */
    protected static function requiredFromArray(array $data, string $field): mixed
    {
        if (! array_key_exists($field, $data)) {
            throw ValidationException::withMessages([$field => ["The {$field} field is required."]]);
        }

        return $data[$field];
    }

    /** @template TEnum of \BackedEnum
     * @param  array<string, mixed>  $data
     * @param  class-string<TEnum>  $enum
     * @return TEnum
     */
    protected static function enumFromArray(array $data, string $field, string $enum): \BackedEnum
    {
        $value = static::requiredFromArray($data, $field);
        if ($value instanceof $enum) {
            return $value;
        }

        $resolved = is_string($value) || is_int($value) ? $enum::tryFrom($value) : null;
        if ($resolved === null) {
            throw ValidationException::withMessages([$field => ["The selected {$field} is invalid."]]);
        }

        return $resolved;
    }
}
