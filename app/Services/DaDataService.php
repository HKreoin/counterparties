<?php

namespace App\Services;

use App\DTO\DaData\DaDataResponseDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class DaDataService
{
    private string $apiUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.dadata.url');
        $this->apiKey = config('services.dadata.key');
    }

    public function getCompanyByInn(string $inn): DaDataResponseDTO
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Token ' . $this->apiKey,
            ])->post($this->apiUrl, [
                'query' => $inn,
                'count' => 1,
            ]);

            if ($response->failed()) {
                Log::error('DaData API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                throw new Exception('Failed to retrieve data from DaData: ' . $response->status());
            }

            $data = $response->json('suggestions.0.data');

            if (empty($data)) {
                throw new Exception('No company found with INN: ' . $inn);
            }

            return new DaDataResponseDTO(
                name: $data['name']['short_with_opf'] ?? '',
                ogrn: $data['ogrn'] ?? '',
                address: $data['address']['unrestricted_value'] ?? '',
            );
        } catch (Exception $e) {
            Log::error('Error fetching company data', [
                'inn' => $inn,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
