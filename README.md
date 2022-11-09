## Test
[![CI](https://github.com/ivanchavez01/omnicloud-api/actions/workflows/ci.yml/badge.svg)](https://github.com/ivanchavez01/omnicloud-api/actions/workflows/ci.yml)

# Instalación

### Clonar repositorio
`git clone git@github.com:ivanchavez01/omnicloud-api.git`

### Instalación con Docker
El setup de docker instalará las siguientes herramientas:
* Ubuntu 18.04
* PHP 8.1
* Apache 2.4
* MySQL 8.1

Construcción de las imagenes.

`docker-compose build`

Construcción de contenedores.

`docker-compose up -d`

### Manipular el contenedor

`docker-compose exec omnicloud-api /bin/bash`

## Instalación Backend

### Instalación de la base de datos

`php artisan migrate`

### Instalación de datos

`php artisan db:seed`

## Correr pruebas de integración

`php artisan test`

## Registro de libros

`php artisan db:seed --class=MoreBooksSeeder`

