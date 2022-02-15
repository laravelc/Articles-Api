# Статьи
Реализовано на Laravel 9. При управлении проектом мы используем команду `docker-compose`
## Установка
1. Скачать
```shell
 git clone git@github.com:hardcoder10/articles-new.git
```
2. Установка библиотек
```shell
composer install
```
2. Скопировать `.env.example` в `.env` и настроить конфигурации
3. Поднять докер
```shell
docker-compose up -d --build
```
4. Войти в контейнер 
```shell
docker-compose exec laravel.test /bin/bash
```
5. Миграции
```shell
php artisan migrate
```

## Генерация документации
```shell
php artisan  l5-swagger:generate
# article-new
