<?php

namespace App\DTO\Counterparty;

use Spatie\LaravelData\Data;

class CounterpartyResponseDTO extends Data
{
    public function __construct(
        public int $id,
        public int $inn,
        public int $user_id,
        public string $name,
        public string $ogrn,
        public string $address,
        public string $created_at,
        public string $updated_at,
    )
    {
    }
}
