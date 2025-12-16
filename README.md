# 📚 LushInk

**LushInk** es una aplicación web  de descubrimiento y lectura de libros hecha en **Laravel 10**. 

El proyecto integra una **API externa (OpenLibrary)** exclusivamente para la búsqueda y obtención de metadatos, mientras que el **contenido de lectura** se sirve desde una **API interna propia**, basada en una base de datos y almacenamiento controlado por la aplicación.

> Los libros solo pueden leerse si han sido “comprados” y existen en la base de datos interna.  
> La API externa no se utiliza para leer contenido.

---

## ✨ Características y estado del proyecto

| Funcionalidad | Descripción | Estado |
|--------------|------------|--------|
| Búsqueda de libros | Búsqueda por título/autor usando OpenLibrary | 🟢 Completado |
| Detalles del libro | Vista de información general del libro | 🟡 En proceso |
| Integración OpenLibrary | Consumo exclusivo para metadatos | 🟢 Completado |
| API interna propia | Endpoints para biblioteca y lectura | 🟡 En proceso |
| Flujo de compra (simulado) | Añadir libros a la biblioteca del usuario | 🟡 En proceso |
| Biblioteca del usuario | Listado de libros comprados | 🟢 Completado |
| Control de acceso | Solo usuarios autenticados pueden leer | 🟢 Completado |
| Lector de libros | Visualización de contenido local (iframe) | 🔵 Planeado |
| Progreso de lectura | Guardar avance por usuario | 🔵 Planeado |
| Subida de archivos (PDF/EPUB) | Gestión de contenido real | 🔵 Planeado |
| Pagos reales | Integración de pasarela de pago | 🔵 Planeado |
| Deploy en la nube | Producción  | 🔵 Planeado |

---

## 🏗️ Arquitectura del sistema

```text
Blade Views (UI)
        |
        | fetch()
        v
API LushInk (Interna)
        |
        ├── BookApiService → OpenLibrary (metadatos)
        |
        └── LibraryController → Base de datos + archivos locales
```


## 🧩 Tecnologías

- **Backend:** Laravel 10  
- **PHP:** 8.2  
- **Frontend:** Blade + Tailwind CSS  
- **Autenticación:** Laravel Breeze  
- **API externa:** OpenLibrary  
- **Base de datos:** MySQL / SQLite (desarrollo)  
- **Servidor local:** `php artisan serve`

---

## 📄 Licencia

**MIT**
