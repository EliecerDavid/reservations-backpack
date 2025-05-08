# Reservations - backpack
Este es un sistema hecho en Laravel con Backpack para manejar reservaciones en un coworking.

## Software usado
- PHP 8.1
- Composer 2.4
- Laravel 10
- [Laravel Backpack 6.8](https://backpackforlaravel.com/)
- [Laravel Excel 3.1](https://laravel-excel.com/)
- MySQL 8.1
- PHPMyAdmin
- Docker
- Makefile

## Puesta en marcha
Se ha usado Docker para levantar el proyecto en contenedores y facilitar la portabilidad del sistema. Para automatizar ciertas tareas se ha usado Makefile por lo que es necesario tenerlo en el sistema para ejecucion mas simple.

Para levantar los contenedores se debe lanzar el siguiente comando
~~~
make up
~~~
Esto iniciara todos los contenedores (nginx, php, mysql, phpmyadmin) y se instalaran las dependiencias, configurara el archivo env y correran las migraciones.

Luego de que termine de ejecutarse el comando, se podra ingresar a la direccion [localhost](http://localhost) donde ya estara el sistema funcionando.

Para crear usuarios admin se debe ejecutar el siguiente comando dentro del contenedor
~~~
php artisan app:create-admin
~~~
o correr el comando
~~~
make admin
~~~
y seguir las instrucciones.
