<?php

namespace App\Actions\Users\UpdateUserPassword;

use App\Support\Actions\Action;
use App\Support\Actions\HandledBy;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\CurrentPassword;
use Spatie\LaravelData\Attributes\Validation\Password;

#[HandledBy(UpdateUserPasswordHandler::class)]
final class UpdateUserPassword extends Action
{
    public function __construct(
        #[CurrentPassword]
        public readonly string $current_password,
        #[Password(default: true), Confirmed]
        public readonly string $password,
        public readonly string $password_confirmation,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            current_password: self::requiredFromArray($data, 'current_password'),
            password: self::requiredFromArray($data, 'password'),
            password_confirmation: self::requiredFromArray($data, 'password_confirmation'),
        );
    }
}
