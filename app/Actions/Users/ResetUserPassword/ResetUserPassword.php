<?php

namespace App\Actions\Users\ResetUserPassword;

use App\Support\Actions\Action;
use App\Support\Actions\HandledBy;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Password;

#[HandledBy(ResetUserPasswordHandler::class)]
final class ResetUserPassword extends Action
{
    public function __construct(
        #[Password(default: true), Confirmed]
        public readonly string $password,
        public readonly string $password_confirmation,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            password: self::requiredFromArray($data, 'password'),
            password_confirmation: self::requiredFromArray($data, 'password_confirmation'),
        );
    }
}
