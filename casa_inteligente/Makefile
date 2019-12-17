 conf:
	cp .env.example .env
	composer install
	php artisan key:generate
	nano .env
	php artisan migrate:fresh --seed
	php artisan serve