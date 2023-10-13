### Json import to Database

Commands
1. composer install
2. ./vendor/bin/sail build --no-cache
3. cp .env.example .env
4. ./vendor/bin/sail up -d
5. docker exec -it json-import-to-db-laravel.test-1 sh -c "chown -R sail:www-data storage && chown -R sail:www-data bootstrap/cache"
6. php artisan key:generate
7. docker exec -it json-import-to-db-laravel.test-1 sh -c "php artisan migrate"
8. ./vendor/bin/sail npm install
9. docker exec -it json-import-to-db-laravel.test-1 sh -c "npm run dev"
10. Network: http://X.X.X.X:5174/ - remove IP address

#### If queue doesn't work with any reason
11. docker exec -it json-import-to-db-laravel.test-1 sh -c "php artisan queue:work"

### Libraries
- halaxa/json-machine 
- yadakhov/insert-on-duplicate-key 
