apidoc:
	php artisan l5-swagger:generate
docker-start:
	docker compose up -d
docker-stop:
	docker compose down
app-setup:
	docker compose exec app composer install
	docker compose exec app npm install
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan migrate --seed
vite-build:
	docker compose exec app npm run build
test:
	php artisan test
