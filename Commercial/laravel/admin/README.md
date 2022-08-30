Админка для управления контентом сайта


## Развернуть Бэк
1. composer install
2. Файл .env.example переименовать в .env
3. php artisan key:generate
4. В файле .env прописать доступы к базе данных - строчки 11-16
5. Выполнить миграции БД - php artisan migrate
6. Выполнить генерацию пользователя - php artisan db:seed
7. Доступы с которыми сгенерируется пользователь - admin@admin.com password
