<?php

namespace App\Actions\Users\UpdateUserProfile;

use App\Models\User;
use App\Support\Actions\Action;
use App\Support\Actions\HandledBy;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Lowercase;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Support\Validation\References\AuthenticatedUserReference;

#[HandledBy(UpdateUserProfileHandler::class)]
final class UpdateUserProfile extends Action
{
    public function __construct(
        #[Max(255)]
        public readonly string $name,
        #[Lowercase, Email, Max(255), Unique(User::class, 'email', ignore: new AuthenticatedUserReference)]
        public readonly string $email,
    ) {}

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            name: self::requiredFromArray($data, 'name'),
            email: strtolower(self::requiredFromArray($data, 'email')),
        );
    }
}
