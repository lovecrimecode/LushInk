# 📚 LushInk

**LushInk** es una aplicación web que permite el **descubrimiento, seguimiento y lectura personalizada de libros**, desarrollada en **Laravel 10**, con integración de **API externa** y una **API interna propia** para la gestión del contenido.

## 🔖 ¿Por qué LushInk?

Este proyecto inició como una solución personal para **visualizar, organizar y dar seguimiento al progreso de lectura** de mis libros, los cuales suelen existir en distintos formatos como **PDF** y **EPUB**.

Con el tiempo, surgió la necesidad de una herramienta que permitiera **descubrir nuevos libros**, guardar información relevante sobre ellos y centralizar todo en un solo lugar.

De esa necesidad nace **LushInk**: una plataforma enfocada en lectores que buscan una experiencia de lectura **integrada, sencilla y personalizable**, donde el contenido y el progreso pertenecen al usuario.


## 🧩 Tecnologías

El proyecto integra una **API externa (OpenLibrary)**  para la **búsqueda y obtención de metadatos** (títulos, autores, descripciones, portadas).

El **contenido de lectura** se sirve desde una **API interna propia**, respaldada por una base de datos y almacenamiento controlado por la aplicación.

Los libros pueden originarse tanto de la API externa como de otras fuentes internas.

- **Backend:** Laravel 10
- **PHP:** 8.2
- **Frontend:** Blade + Tailwind CSS
- **Autenticación:** Laravel Breeze
- **API externa:** OpenLibrary
- **Base de datos:** MySQL / SQLite (desarrollo)

<!---

## 🚀 Quick Start (local)

1. Clona el repositorio
    
    ```bash
    git clone <https://github.com/tu-usuario/lushink.git>
    cd lushink
    ```
    
2. Instala dependencias
    
    ```bash
    composer install
    npm install
    npm run dev
    ```
    
3. Configura el entorno
    
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    
4. Configura la base de datos en `.env` y ejecuta migraciones
    
    ```bash
    php artisan migrate
    ```
    
5. Inicia el servidor
    
    ```bash
    php artisan serve
    ```

Accede a la aplicación en:

`http://127.0.0.1:8000`

--->
## 📄 Licencia

**MIT**