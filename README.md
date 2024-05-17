# Gamerfest

## Dependencias

## Extensiones Recomendadas

-   [Vue - Official](https://marketplace.visualstudio.com/items?itemName=Vue.volar)
-   [Error Lens](https://marketplace.visualstudio.com/items?itemName=usernamehw.errorlens)

## Instalación

1. Clonar el repositorio

```sh
git clone https://github.com/tellxmaster/gamerfest_project.git
```

2. Instalar dependencias de php con composer

```sh
composer install
```

3. Instalar dependencias de node para VueJS

```sh
npm install
```

4. Copiar configuración de variables de entorno `.env`

```sh
cp .env.example .env
```

5. Generar `key` de aplicación

```sh
php artisan key:generate
```

6. **(Opcional)** Configurar accesos a la base de datos en `.env`

```dot
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gamerfest_project
DB_USERNAME=root
DB_PASSWORD=
```

7. Levantar servidor de Apache y Base de datos (MySQL) con [XAMPP](https://www.apachefriends.org/es/index.html).

8. Reconstruir la base de datos

```sh
php artisan migrate
```

> **Nota:** Se puede crear la base de datos con el nombre `gamerfest_project` o con el nombre definido en `DB_NAME` en el archivo `.env`, caso contrario nos dara un `WARN: The database 'gamerfest_project' does not exist on the 'mysql' connection.` aqui responderemos `yes` y creara la base de datos automáticamente.

9. Sembrar datos en la bdd

```sh
php artisan db:seed
```

> **Nota:** Este comando inserta automaticamente los roles de los usuarios ['admin','jugador'] ademas de los permisos y los juegos, estos datos pueden ser cambiados en el directorio `database\seeders`.

## Uso de reCAPTCHA

Para evitar ataques de tipo DDOS, se ha implementado reCAPTCHA, el cual se encuentra desactivado actualmente. Para activarlo en el entorno de producción:

1. Descomentar el código ubicado en las `línea 64` y `líneas 67 a 71` del archivo `app\Http\Controllers\Auth\RegisteredUserController.php`.

```php
$recaptchaIsValid = $this->verifyRecaptcha($request->input('recaptcha'));

if (!$recaptchaIsValid) {
     return back()->withErrors(['recaptcha' => 'Invalid reCAPTCHA.']);
}
```

2. Descomentar el código ubicado en la `línea 56 a 60` del archivo `app\Http\Controllers\Auth\AuthenticatedSessionController.php`

3. Generar una variable de entorno en `RECAPTCHA_SECRET` en `.env` y ingresar el secret para obtener el secret es necesario crear uno mirar como en [Crea claves de reCAPTCHA para sitios web](https://cloud.google.com/recaptcha-enterprise/docs/create-key-website?hl=es-419).
