This codebase was created to demonstrate a fully fledged fullstack application built with **Laravel + HTMX** that adheres to the [RealWorld](https://github.com/gothinkster/realworld) spec

## Project Overview

"Conduit" is a social blogging site (i.e. a Medium.com clone). It uses a custom API for all requests, including authentication.

# Installation
```
1. clone this repository
2. copy .env.example and change it to .env
3. composer install
4. php artisan migrate:fresh --seed (sqlite is enough, and is included within this repository)
5. php artisan serve
6. use test@email.com|secret for logging in
	6.1. or can register from the web
```
