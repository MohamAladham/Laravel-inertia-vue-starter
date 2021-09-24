# README #

## Installation:

- run `composer install` to install vendor packages
- make storage and bootstrap folder writable `chmod -R 777 storage bootstrap`
- run `php artisan storage:link` to make them accessible from the web
- rename `.env.example ` to `.env ` and set necessary configs
- run `php artisan key:generate` to generate new application key
- run `php artisan migrate` to run database migrations
- for test proposal run `php artisan serve`

**Notes:**

- _Each project pull you must run command `php artisan migrate` to migrate new database changes_
- _If there is new packages added to composer file don't forget to run command `composer update`_

#### Setup CronJob

- `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`
