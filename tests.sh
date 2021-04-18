touch database/test.sqlite

php artisan migrate --env=testing
php artisan test --env=testing
php artisan migrate:rollback --env=testing