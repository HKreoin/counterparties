# Приложение для внесения контрагентов в справочник

## Инструкция

Скопируйте репозиторий

```bash
git clone https://github.com/HKreoin/counterparties.git
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

Установите утилиту make если она у вас не установлена

```bash
apt install make
```

```bash
make docker-start
```

После запуска контейнеров для настройки приложения введите

```bash
make app-setup
make vite-build
```

Данные для входа

email: test@example.com

password: password
