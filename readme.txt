steps to setup project

1) .env.example rename as .env
2) setup database in mysql
3) command to run
    composer install
    php artisan key:generate
    php artisan migrate
    php artisan config:cache
    php artisan config:clear
    php artisan optimize:clear
    php artisan serve

note :
    by default last interval is included in result if you dont want to go till the last interval which might be greater than end date then form .env file

    set or update key   
    INCLUDE_LAST_OCCRENCE = false