<?php

namespace App\DTO\Counterparty;

use Spatie\LaravelData\Data;

class CounterpartyDTO extends Data
{
    public function __construct(
        public int $id,
        public int $inn,
        public int $user_id,
        public ?string $name = null,
        public ?string $ogrn = null,
        public ?string $address = null,
    ) {
    }
}
