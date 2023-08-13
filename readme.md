## Установка
1. Копируем файл в корне проекта `docker-compose.yml.example` в эту же директорию и переименовываем его в `docker-compose.yml`  
2. Копируем файл в корне проекта `.env.example` в эту же директорию и переименовываем его в `.env`
3. Копируем файл из папки `docker/.env.example` в эту же директорию и переименовываем его в `.env`
4. Запускаем проект командой `docker-compose --env-file docker/.env up --build`
5. Запускаем установку пактов командой ` docker-compose exec app composer install`
6. Запускаем команду создание базы данных и таблиц `docker-compose exec app php console db:migrate`
7. Проект с настройками по умолчанию становится доступен по ссылке - http://localhost:8082/

## Команда для генерации промокодов:
`docker-compose exec app php console db:promo_codes:generate --size=500000`