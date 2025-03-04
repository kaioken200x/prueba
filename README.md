# Proyecto Laravel 11 - Prueba

## Descripción del Proyecto

Este proyecto es una aplicación web desarrollada con Laravel 11. La aplicación permite gestionar proyectos y tareas, generando informes en formato PDF utilizando la biblioteca `SnappyPdf`.

## Manual de Uso

### Requisitos Previos

- PHP 8.0 o superior
- Composer
- wkhtmltopdf (para la generación de PDFs)
- Mysql 8

### Instalación

1. Clona el repositorio:

    ```sh
    git clone https://github.com/kaioken200x/prueba.git
    ```

2. Instala las dependencias de Composer:

    ```sh
    composer install
    ```

3. Copia el archivo [.env.example](http://_vscodecontentref_/1) a [.env](http://_vscodecontentref_/2) y configura tus variables de entorno:

    ```sh
    cp .env.example .env
    ```

4. Configura la base de datos en el archivo [.env](http://_vscodecontentref_/3):

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nombre_de_tu_base_de_datos
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña
    ```

5. Genera la clave de la aplicación:

    ```sh
    php artisan key:generate
    ```

6. Ejecuta las migraciones:

    ```sh
    php artisan migrate
    ```

7. Inicia el servidor de desarrollo:

    ```sh
    php artisan serve
    ```

### Uso

1. Accede a la aplicación en tu navegador web en `http://127.0.0.1:8000`.
2. Regístrate o inicia sesión.
3. Gestiona tus proyectos y tareas desde el panel de control.
4. Genera informes en formato PDF desde la sección de informes.

## Información del Servidor Web

Este proyecto puede ser desplegado en cualquier servidor web compatible con PHP, como Apache o Nginx.