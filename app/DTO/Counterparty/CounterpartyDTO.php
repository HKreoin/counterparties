<?php

namespace App\DTO\Counterparty;

use Spatie\LaravelData\Data;

class CounterpartyDTO extends Data
{
    public function __construct(
        public string $inn,
        public ?string $name = null,
        public ?string $ogrn = null,
        public ?string $address = null,
    ) {
    }

    public static function fromDaDataResponse(array $data): self
    {
        return new self(
            inn: $data['inn'],
            name: $data['name']['short_with_opf'] ?? '',
            ogrn: $data['ogrn'] ?? '',
            address: $data['address']['unrestricted_value'] ?? '',
        );
    }
}
