<?php

use App\DTO\DaData\DaDataResponseDTO;
use App\Models\User;
use App\Services\DaDataService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('test-token')->plainTextToken;
});

test('user can create counterparty', function () {
    // Mock DaDataService
    $mockDaDataService = Mockery::mock(DaDataService::class);
    $mockDaDataService->shouldReceive('getCompanyByInn')
        ->once()
        ->with('7707083893')
        ->andReturn(new DaDataResponseDTO(
            name: 'ПАО СБЕРБАНК',
            ogrn: '1027700132195',
            address: 'г Москва, ул Вавилова, д 19'
        ));

    $this->app->instance(DaDataService::class, $mockDaDataService);

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->token,
    ])->postJson('/api/v1/counterparties', [
        'inn' => '7707083893',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'id', 'inn', 'name', 'ogrn', 'address', 'created_at', 'updated_at',
        ]);

    $this->assertDatabaseHas('counterparties', [
        'user_id' => $this->user->id,
        'inn' => '7707083893',
        'name' => 'ПАО СБЕРБАНК',
        'ogrn' => '1027700132195',
    ]);
});

test('user can get counterparties', function () {
    // Create a counterparty for the user
    $this->user->counterparties()->create([
        'inn' => '7707083893',
        'name' => 'ПАО СБЕРБАНК',
        'ogrn' => '1027700132195',
        'address' => 'г Москва, ул Вавилова, д 19',
    ]);

    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->token,
    ])->getJson('/api/v1/counterparties');

    $response->assertStatus(200)
        ->assertJsonCount(1)
        ->assertJsonStructure([
            '*' => ['id', 'inn', 'name', 'ogrn', 'address', 'created_at', 'updated_at'],
        ]);
});

test('unauthorized user cannot access counterparties', function () {
    $response = $this->getJson('/api/v1/counterparties');
    $response->assertStatus(401);
});
