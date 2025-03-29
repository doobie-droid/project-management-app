# Project Management App

Submission for Coalition assessment, includes CRUD application for managing tasks, filtering tasks based on projects, and interface for re-ordering tasks via drag and drop in the browser
<br><br>

### PRE-REQUISITES

| Tool    | Version |
| ------- | ------- |
| PHP     | ^8.2.x  |
| MYSQL   | ^5.7.x  |
| Laravel | ^9.5.x  |

### LOCAL SETUP

1. clone repository
2. copy .env.example file to .env and also to .env.testing file. Go to [Configuration](#configuration) to set DB details

```
cp .env.example .env && cp .env.example .env.testing
```

3. Download Dependencies

```
composer install
```

4. Set encryption key

```
php artisan key:generate
```

5. Perform migrations and seed database and migrate db for testing database

```
php artisan migrate --seed && php artisan migrate  --env=testing
```

6. You can then build tailwind css related assets by running

```
npm run build
```

7. Spin up a local server by and visit the homepage: You will find a link to all tasks there

```
php artisan serve
```

### TESTING

1. After setting up, you can run the tests by running:

```
php artisan test
```

2. To see code coverage for the tests, install [xdebug][xdebug-url] and then run

```
php artisan test --coverage
```

### configuration

Please modify these values in the `.env` file.

-   DB_DATABASE=coalition
-   DB_PASSWORD=**\*\*\*\*** (Put your password here, leave blank if your mysql root uses no password)

Please modify these values in the `.env.testing` file.

-   DB_DATABASE=coalition_testing
-   DB_PASSWORD=**\*\*\*\*** (Put your password here, leave blank if your mysql root uses no password)

[xdebug-url]: https://xdebug.org/docs/install
