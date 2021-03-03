
<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

## Sobre Lioncore

Es una aplicación de uso general basada en laravel.

## Instalación

Instalación de dependencias php.
```
composer update
```
En el directorio raíz, encontrará un archivo llamado .env.example cambie el nombre del archivo dado a .env y ejecute el siguiente comando para generar la clave (y también puede editar las credenciales de su base de datos aquí)
```
php artisan key:generate
```
```
php artisan jwt:secret
```
```
php artisan module:migrate --seed
```

Para la migracion en un ambiente de prueba se ejecuta lo siguiente (se debe tener un archivo .env.testing en la raiz del proyecto)
```
php artisan migrate:migrate --seed --env=testing
```

Para cambiar la dirección del puerto, ejecute el siguiente comando:

```text
php artisan serve --host=lioncore.oo --port=8080    // Para el puerto 8080
sudo php artisan serve --host=lioncore.oo --port=80 // Si desea ejecutarlo en el puerto 80, probablemente necesite sudo.
```
