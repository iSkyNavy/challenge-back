# Backend Challenge
## Laravel, MYSQL
### Technologies
- Laravel 10
- PHP 8.2
- Mysql 8
### Steps to start
- Chnage your own values in '.env' file
- php artisan migrate
- php artisan db:seed
- php artisan serve

## Endpoints

**You can see the routes with the command => php artisan.**

  GET   api/division => To get all Divisions.

  POST  api/division => To save a Division.

  GET  api/division/names => To get all names of divisions.

  GET  api/division/superior/names => To get all names of superior names.

  GET  api/division/{id} => To get an specific Divion.

  PATCH  api/division/{id} => To update an specific Division.

  DELETE api/division/{id} => To delete an specific Division

## TODO
- Unit tests
