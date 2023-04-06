# Usage

## Run npm and composer
Before we start, we need to install all PHP and Node packages.
```
npm install
composer install
```

## Setup the .env file

Copy the __.env.example__ file and edit the fields according to your MySQL setup:
 1. DB_CONNECTION
 2. DB_HOST
 3. DB_PORT
 4. DB_DATABASE
 5. DB_USERNAME
 6. DB_PASSWORD

## Run the DB Migrations
```
php run migrate
```
You can also add `--seed` to the command so that you can run the default DB seeders.

## Generate new key
Make sure you generate a new key for the application 
`php artisan key:generate`

## Serve the project
Run the project with the command `php artisan serve` and you should be given the link to access the project in your terminal.

## HMR
If you need the Hot Module Replacement to work, run the command `npm run dev`.
Access the link through the link when you ran `php artisan serve`.

## Unit Tests
You can run the command `php artisan test`.
The project currently tests the following:
- authentication
- creating new users
- password confirm
- password reset
- user can delete account
- if user can like pokemon
- if user can hate pokemon
- if user can favorite a pokemon
- expect error when like more than 3 pokemon
- expect error when hate more than 3 pokemon
- expect error when favorite more than 1 pokemon