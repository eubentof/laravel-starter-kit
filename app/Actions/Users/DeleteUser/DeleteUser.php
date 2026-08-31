<?php

namespace App\Actions\Users\DeleteUser;

use App\Support\Actions\Action;
use App\Support\Actions\HandledBy;
use Spatie\LaravelData\Attributes\Validation\CurrentPassword;

#[HandledBy(DeleteUserHandler::class)]
final class DeleteUser extends Action
{
    public function __construct(
        #[CurrentPassword]
        public readonly string $password,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(password: self::requiredFromArray($data, 'password'));
    }
}
