<?php

namespace App\Actions\Users\RegisterUser;

use App\Models\User;
use App\Support\Actions\Action;
use App\Support\Actions\HandledBy;
use Spatie\LaravelData\Attributes\Validation\Confirmed;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Lowercase;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Unique;

#[HandledBy(RegisterUserHandler::class)]
final class RegisterUser extends Action
{
    public function __construct(
        #[Max(255)]
        public readonly string $name,
        #[Lowercase, Email, Max(255), Unique(User::class, 'email')]
        public readonly string $email,
        #[Password(default: true), Confirmed]
        public readonly string $password,
        public readonly string $password_confirmation,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            name: self::requiredFromArray($data, 'name'),
            email: strtolower(self::requiredFromArray($data, 'email')),
            password: self::requiredFromArray($data, 'password'),
            password_confirmation: self::requiredFromArray($data, 'password_confirmation'),
        );
    }
}
