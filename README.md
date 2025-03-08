# Приложение для внесения контрагентов в справочник

## Инструкция

Скопируйте репозиторий

```bash
git clone git@github.com:HKreoin/counterparties.git
```

Перейдите в папку counterparties

```bash
cd counterparties
```

Скопируйте файл .env.example и переименуйте в .env

```bash
cp .env.example .env
```

Укажите ключ от DaDAta API

```
DADATA_API_KEY=ваш ключ API
```

## Запуск Docker

```
docker-compose up -d
```

Создаем ключ приложения

```
docker-compose exec app php artisan key:generate
```

Собираем фронтенд

```
docker-compose exec app npm run build
```

Для создания пользователя и контрагентов

```bash
docker-compose exec app php artisan migrate --seed
```

Данные для входа

email: test@example.com

password: password

либо можете зарегистрировать своего и использовать комманду для создания списка контрагентов

```bash
docker-compose exec app php artisan db:seed --class=CounterpartySeeder
```
