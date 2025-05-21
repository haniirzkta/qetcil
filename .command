php artisan make:model UserAddress -m
php artisan make:model Category -m
php artisan make:model Bouquet -m
php artisan make:model BouquetPhoto -m
php artisan make:model Bank -m
php artisan make:model Cart -m
php artisan make:model BouquetTransaction -m

php artisan make:filament-resource Category
php artisan make:filament-resource Bouquet
php artisan make:filament-resource BouquetPhoto
php artisan make:filament-resource Bank
php artisan make:filament-resource Cart
php artisan make:filament-resource BouquetTransaction
php artisan make:filament-resource User

php artisan make:controller FrontController
php artisan make:controller CartController

create user:
php artisan make:filament-user

update resource:
php artisan filament:cache-components

clear:
php artisan cache:clear
php artisan config:clear
php artisan view:clear

path login:
vendor\filament\filament\src\Http\Middleware\Authenticate.php
