
<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

## Sobre Lioncore

Es una aplicación de uso general basada en laravel y vuejs.

## Instalación
Se debe deber vue cli instalado: 
```
npm install -g @vue/cli
```
Instalación de dependencias npm.
```
npm install
```
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

Para cambiar la dirección del puerto, ejecute el siguiente comando:

```text
php artisan serve --port=8080    // Para el puerto 8080
sudo php artisan serve --port=80 // Si desea ejecutarlo en el puerto 80, probablemente necesite sudo.
```

Para ejecutar el proyecto, debe ejecutar el siguiente comando en el directorio del proyecto. Compilará los archivos vue y todos los demás archivos del proyecto. Si está realizando cambios en alguno de los archivos .vue, debe ejecutar el comando dado nuevamente.

```text
npm run dev
```
**Esperando cambios:**  Ejecutar `npm run dev` cada vez que realiza cambios en el archivo es ineficiente. Esperemos que haya un comando para que sus cambios se puedan ver y reflejarse en consecuencia.

```text
npm run watch
```


**La construcción para Producción:**  Si desea ejecutar el proyecto y realizar la compilación en el modo de producción, ejecute el siguiente comando en el directorio raíz; de lo contrario, el proyecto continuará ejecutándose en el modo de desarrollo.

```text
npm run prod
```
