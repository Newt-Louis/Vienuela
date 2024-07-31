# Vienula (A Trello Clone used Vue + Laravel)
*-- This repository contains the RESTful API for project Vienuela. --*

## Getting start
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisite
* Git
* Composer version: 2.7.2 and above.
* PHP version: 8.2.21 and above.
* MySQL version: 8.0.30 and above.
* Laragon, XAMPP, WAMP or something similar.

### Install

Clone the git repository on your computer.
> $ git clone https://github.com/Newt-Louis/Vienuela.git

You can also download the entire repository as a zip file and unpack in on your computer if you do not have git

After cloning the application, you need to install it's dependencies.

> $ cd Vienuela

> $ composer install

### Setup
* After waiting for composer completely installed. 
Then we need to setup some config for database in file `.env`

* Copy file `.env.example` to `.env`

> $ cp .env.example .env

* If you use another database you have to change some infomation in this file `.env`

```
DB_CONNECTION=mysql    // --> change to your database
DB_HOST=127.0.0.1      // --> default IP address
DB_PORT=3306           // --> your database port 
DB_DATABASE=vienuela   // --> default database (don't change this)
DB_USERNAME=root       // --> if you have set username and password of your database 
DB_PASSWORD=           // --> you need to assign here
```

* Migrate the application
> $ php artisan migrate
* You have to run migrate first beacuse it will  ask you to create a new database
* Seed Database
> $ php artisan db:seed
* Run the application
> $ php artisan serve

## Build with
* [Laravel](https://laravel.com/) - The PHP framework for building the API endpoints needed for the application

## Full Project
* This repository only Backend API, for the full project you need to clone **[this Vue project](https://github.com/Newt-Louis/Vienuela-FE)** either !
