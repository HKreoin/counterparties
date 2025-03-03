<?php
namespace App\DTO\Counterparty;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Regex;

class CreateCounterpartyDTO extends Data
{
    public function __construct(
        #[Required, StringType, Regex('/^[0-9]{10}$|^[0-9]{12}$/')]
        public string $inn,
    ) {
    }
}
