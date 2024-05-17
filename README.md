# Gamerfest 👾

!Bienvenid@ al equipo de desarrollo de Gamerfest! Si estás leyendo esto, es porque hemos visto en ti el potencial para contribuir significativamente a este emocionante proyecto 🚀. Gamerfest no es solo un evento de videojuegos, es una plataforma creada con las herramientas de [Laravel](https://laravel.com/docs/11.x) y [Vue](https://vuejs.org), Aquí, cada línea de código que escribas, cada función que implementes, será parte de algo grande que resonará en toda la carrera 💙. Este es tu momento de brillar y dejar tu marca en el mundo del desarrollo de software. ¡Suerte!

## Dependencias

-   [Composer v2.7.3](https://getcomposer.org)
-   [PHP v8.2.12](https://www.apachefriends.org/es/index.html)
-   [Node V20.11.1](v20.11.1)

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

10. Finalmente ejectutar el servidor de php y vue simultaneamente en dos instancias del `cmd`, `terminal`, `bash` o `powershell`

    -   Iniciar frontend con Vue

    ```sh
    npm run dev
    ```

    -   Iniciar Backend con Laravel

    ```sh
    php artisan serve
    ```

11. Acceder a [http://127.0.0.1:8000](http://127.0.0.1:8000)

12. Antes de realizar cambios al código revisa la sección [Github y Control de Versiones](#github-y-control-de-versiones)

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

    ```php
    $recaptchaIsValid = $this->verifyRecaptcha($request->input('recaptcha'));
    if (!$recaptchaIsValid) {
        return back()->withErrors(['recaptcha' => 'Invalid reCAPTCHA.']);
    }
    ```

3. Generar una variable de entorno en `RECAPTCHA_SECRET` en `.env` y ingresar el secret para obtener el secret es necesario crear uno mirar como en [Crea claves de reCAPTCHA para sitios web](https://cloud.google.com/recaptcha-enterprise/docs/create-key-website?hl=es-419).

## Esquema Base de Datos

![Esquema Base de Datos](public\assets\bd.png)

## Estructura de Directorios

### Frontend

Todos los archivos del FrontEnd construido con Vue se encuentran centralizada en `resources` esta cuenta con 3 subdirectorios, que contienen toda la lógica, componentes tanto de Vue como Blade para los certificados e email de recuperación:

```
resources\
├───css
│   └───backgrounds
├───js
│   ├───Components
│   ├───Layouts
│   └───Pages
│       ├───Auth
│       ├───DashboardPage
│       │   ├───Inscripciones
│       │   └───ParticipantesPage
│       └───Profile
│           └───Partials
└───views
    ├───reportes
    └───vendor
        └───notifications
├───css
│   └───backgrounds
├───js
│   ├───Components
│   ├───Layouts
│   └───Pages
│       ├───Auth
│       ├───DashboardPage
│       │   ├───Inscripciones
│       │   └───ParticipantesPage
│       └───Profile
│           └───Partials
└───views
    ├───reportes
    └───vendor
        └───notifications
```

### Backend

El backend por otro lado se encuentra centralizado dentro del directorio `app` que tiene la siguiente estructura, que cuenta con los `Models` en donde se encuentran las entidades, `Http\Controllers` que centraliza la lógica de negocio y `Http\Middlewares` que controlan el Acceso a las páginas.

```
app\
├───Console
├───Exceptions
├───Http
│   ├───Controllers
│   │   └───Auth
│   ├───Middleware
│   └───Requests
│       └───Auth
├───Models
└───Providers
```

## ❓FAQ (Preguntas Frecuentes)

### ¿Comó creo un usuario administrador?

Para crear un usuario con el rol administrador es necesario en el archivo `app\Http\Controllers\Auth\RegisteredUserController.php` cambiar la `línea 80` la palabra `jugador`:

```php
$defaultRole = Role::where('name', 'jugador')->first();
```

por la palabra `admin`:

```php
$defaultRole = Role::where('name', 'admin')->first();
```

> **Nota:** Una vez registrado el administrador regresar la `línea 80` a su estado inicial, se recomienda registrar administradores fuera del entorno de producción

## Github y Control de Versiones

### ⛔ Guía de Prefijos para Commits

Utilizar prefijos en los commits ayuda a entender rápidamente el propósito del cambio y facilita la navegación por el historial del proyecto. A continuación, se presentan algunos prefijos comunes que pueden utilizar:

-   **feat**: Añade una nueva característica o un nuevo archivo al proyecto.
-   **fix**: Corrige bugs o problemas en el código existente.
-   **docs**: Cambios solo en la documentación.
-   **style**: Cambios que no afectan el significado del código (espacios, formato, faltas de ortografía, etc.).
-   **refactor**: Cambios en el código que ni corrigen un bug ni añaden una característica.
-   **test**: Añade o modifica pruebas.
-   **chore**: Actualizaciones de tareas rutinarias; por ejemplo, cambios en las herramientas de construcción y dependencias.

### ⛔ Gestión de Ramas

Para mantener organizado el repositorio, cada desarrollador debe seguir estas directrices para la creación y gestión de ramas:

1. **Creación de Ramas**: Cada desarrollador debe crear su propia rama de trabajo con el formato `dev_{nombre_usuario}`. Esto asegura que cada miembro del equipo tenga un espacio propio para desarrollar y probar sus cambios sin interferir con el trabajo de los demás.

2. **Pull Requests**: Todos los pull requests deben dirigirse a la rama `desarrollo`. Esta rama sirve como área de integración antes de que los cambios se fusionen a la rama principal. Asegúrate de revisar y probar los cambios en esta rama de manera exhaustiva.

3. **Fusiones (Merges) y Conflictos**: Al trabajar con pull requests, es posible que se presenten conflictos de fusión. Es responsabilidad de cada desarrollador resolver estos conflictos en su rama antes de completar el pull request.

### 📕 Notas Adicionales

-   Antes de realizar un commit, asegúrate de realizar pruebas locales para confirmar que los cambios no rompan ninguna funcionalidad existente.
-   Mantén los mensajes de los commits claros y descriptivos, siguiendo los prefijos establecidos.
