<?php

namespace App\DTO\DaData;

use Spatie\LaravelData\Data;

class DaDataResponseDTO extends Data
{
    public function __construct(
        public string $name,
        public string $ogrn,
        public string $address,
    ) {
    }
}
