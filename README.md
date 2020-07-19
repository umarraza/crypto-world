# Tracking App Project - Laravel 7.0

## Required packages

- Laravel Permission: https://github.com/spatie/laravel-permission
- Laravel Collective: https://laravelcollective.com/docs/6.0/html
- Laravel laravel-nist-password-rules: https://laravelcollective.com/docs/6.0/html

## Setup Instruction
- composer update
- php artisan key:generate
- Create Database
- Add imports directory in storage/app/public
- php artisan migrate
- php artisan db:seed
- php artisan storage:link
- Login:
	- Email: admin@admin.com
	- Password: secret
