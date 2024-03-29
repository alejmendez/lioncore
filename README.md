
<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

## Sobre Lioncore

Es una aplicación de uso general basada en laravel.

## Instalación

Instalación de dependencias php.
```sh
$ composer update
```

En el directorio raíz, encontrará un archivo llamado .env.example cambie el nombre del archivo dado a .env y ejecute el siguiente comando para generar la clave (y también puede editar las credenciales de su base de datos aquí)
```sh
$ php artisan key:generate
```

```sh
$ php artisan jwt:secret
```

```sh
$ php artisan migrate --seed
```

Para la migracion en un ambiente de prueba se ejecuta lo siguiente (se debe tener un archivo .env.testing en la raiz del proyecto)
```sh
$ php artisan migrate --seed --env=testing
```

Para cambiar la dirección del puerto, ejecute el siguiente comando:

```sh
$ php artisan serve --host=lioncore.oo --port=8080    # Para el puerto 8080
$ sudo php artisan serve --host=lioncore.oo --port=80 # Si desea ejecutarlo en el puerto 80, probablemente necesite sudo.
```
