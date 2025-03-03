<?php

namespace App\Services;

use App\DTO\Counterparty\CounterpartyResponseDTO;
use App\DTO\Counterparty\CreateCounterpartyDTO;
use App\Models\Counterparty;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CounterpartyService
{
    public function __construct(private DaDataService $daDataService)
    {
    }

    public function createCounterparty(User $user, CreateCounterpartyDTO $data): CounterpartyResponseDTO
    {
        // Get company details from DaData
        $companyData = $this->daDataService->getCompanyByInn($data->inn);

        // Create counterparty
        $counterparty = Counterparty::create([
            'user_id' => $user->id,
            'inn' => $data->inn,
            'name' => $companyData->name,
            'ogrn' => $companyData->ogrn,
            'address' => $companyData->address,
        ]);

        return CounterpartyResponseDTO::from($counterparty);
    }

    public function getUserCounterparties(User $user): Collection
    {
        return $user->counterparties()->get()->map(function (Counterparty $counterparty) {
            return CounterpartyResponseDTO::from($counterparty);
        });
    }

    public function counterpartyExists(string $inn): bool
    {
        $user = Auth::user();
        return $user->counterparties()->where('inn', $inn)->exists();
    }

}
