<?php

use App\DTO\DaData\DaDataResponseDTO;
use App\Models\User;
use App\Services\DaDataService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken('test-token')->plainTextToken;
    
    // Здесь мы создаем мок DaDataService для всех тестов
    $this->mockDaDataService = Mockery::mock(DaDataService::class);
    $this->app->instance(DaDataService::class, $this->mockDaDataService);
});

// Запускается после каждого теста
afterEach(function () {
    // Закрываем мок после каждого теста
    Mockery::close();
});

test('user can create counterparty', function () {
    // Настраиваем поведение мока
    $this->mockDaDataService->shouldReceive('getCompanyByInn')
        ->once()
        ->with('7707083893')
        ->andReturn(new DaDataResponseDTO(
            name: 'ПАО СБЕРБАНК',
            ogrn: '1027700132195',
            address: 'г Москва, ул Вавилова, д 19'
        ));
    
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
    // Для этого теста не нужен мок, так как мы напрямую создаем данные
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

// Если нужно протестировать валидацию или обработку ошибок
test('invalid inn returns validation error', function () {
    // Мок не нужно настраивать для теста валидации, так как запрос не дойдет до сервиса
    
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->token,
    ])->postJson('/api/v1/counterparties', [
        'inn' => '123', // Неверный ИНН
    ]);
    
    $response->assertStatus(422);
});

// Тест на обработку ошибок от DaData
test('dadata service error is handled properly', function () {
    // Настраиваем мок, чтобы он выбрасывал исключение
    $this->mockDaDataService->shouldReceive('getCompanyByInn')
        ->once()
        ->with('7707083893')
        ->andThrow(new \Exception('DaData API error'));
    
    $response = $this->withHeaders([
        'Authorization' => 'Bearer ' . $this->token,
    ])->postJson('/api/v1/counterparties', [
        'inn' => '7707083893',
    ]);
    
    $response->assertStatus(500); // Или другой код ошибки, который ваше приложение возвращает
});