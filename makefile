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
	docker compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
	docker compose exec app php artisan migrate --seed
vite-build:
	docker compose exec app npm run build
update-nginx-conf:
	docker compose exec nginx cp /etc/nginx/conf.d/app.conf.template /etc/nginx/conf.d/default.conf
test:
	php artisan test
