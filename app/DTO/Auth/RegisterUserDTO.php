<?php

namespace App\DTO\Auth;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class RegisterUserDTO extends Data
{
    public function __construct(
        #[Nullable, StringType]
        public ?string $name = null,

        #[Nullable, StringType]
        public ?string $firstname = null,

        #[Nullable, StringType]
        public ?string $lastname = null,

        #[Nullable, StringType]
        public ?string $patronymic = null,

        #[Required, Email, Unique('users', 'email')]
        public string $email,

        #[Required, StringType, Min(8)]
        public string $password,
    ) {
    }
}
