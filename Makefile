init:
	docker-compose build --force-rm --no-cache
	make up

up:
	docker-compose up -d
	echo "App is running at http://127.0.0.1:8080"

schema-update:
	docker exec -it test-api /var/www/bin/console doctrine:database:create --if-not-exists
	docker exec -it test-api /var/www/bin/console doctrine:schema:update --force