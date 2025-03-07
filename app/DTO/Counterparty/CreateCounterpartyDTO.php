<?php
namespace App\DTO\Counterparty;

use Spatie\LaravelData\Attributes\Validation\DigitsBetween;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Required;

class CreateCounterpartyDTO extends Data
{
    public function __construct(
        #[Required, DigitsBetween(10, 12), Unique('counterparties', 'inn')]
        public int $inn,
    ) {
    }
}
