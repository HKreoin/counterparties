<?php

namespace App\DTO\Auth;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class LoginUserDTO extends Data
{
    public function __construct(
        #[Required, Email]
        public string $email,

        #[Required, StringType]
        public string $password,
    ) {
    }
}
