## About Laravel Starter

This is starter kit for laravel with permission roles.

### How to install
1. Open your terminal and clone this with command `git clone https://github.com/adiputra22/laravel7-starter-kit-adminlte`
2. After success, then you go to folder with this command `cd laravel7-starter-kit-adminlte`
3. Then you create .env file from .env.example file with this command `cp .env.example .env`
4. Create empty database in your machine. Example name: `laravel7-starter-kit-adminlte`
5. Open your .env file and change maybe like this one:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel7-starter-kit-adminlte
    DB_USERNAME=admin
    DB_PASSWORD=admin
    ```

    Follow your database config for username and password.

6. Install tables with this command `php artisan migrate --seed`
7. After success then now create generate key with this command `php artisan key:generate`