# LushInk — guía funcional (actualizada)

LushInk es una app Laravel para **descubrir libros**, **guardarlos en la biblioteca del usuario** y **dar seguimiento de lectura**.

Esta guía resume cómo está organizada la app y cómo fluye cada funcionalidad principal para que puedas crear/arreglar vistas sin romper la lógica.

---

## 1) Arquitectura general

Separación principal:

- **Vistas Blade (UI):** renderizan pantallas y hacen `fetch` a endpoints JSON.
- **Controladores de página (`PageController`):** devuelven vistas HTML.
- **Controladores API (`Api*Controller`):** devuelven datos JSON para el frontend.
- **Servicios (`BookApiService`):** integración externa con OpenLibrary.
- **Modelos Eloquent (`Book`, `Purchase`, `ReadingProgress`):** persistencia local.

Objetivo: mantener controladores delgados y concentrar la integración externa en `BookApiService`.

---

## 2) Rutas clave

### Rutas de página (`routes/web.php`)

- `GET /` → `PageController@home`
- `GET /book/search` → vista de búsqueda
- `GET /book/{id}` → vista detalle del libro
- `GET /library` (auth) → vista de biblioteca del usuario
- `POST /purchase` (auth) → compra/guardado de libro en biblioteca
- `POST /books/{book}/progress` (auth) → guarda progreso de lectura
- `GET /read/{book}` (auth) → abre archivo del libro si existe

### Rutas API (`routes/api.php`)

- `GET /api/books` → recomendados/trending
- `GET /api/search?q=` → búsqueda
- `GET /api/show/{id}` → detalle normalizado
- `GET /api/library` (auth) → biblioteca del usuario + progreso

---

## 3) Flujo de búsqueda y detalle

### Búsqueda

1. Usuario entra a `/book/search`.
2. La vista `search.blade.php` llama `GET /api/search?q=...`.
3. `ApiBookController@search` delega a `BookApiService::search()`.
4. El servicio normaliza respuesta y devuelve objetos con forma consistente:
   - `work_id`
   - `title`
   - `author`
   - `published_year`
   - `cover_url`

### Recomendados (sin query)

Si `q` está vacío, `BookApiService::search('')` usa `index()` (trending), mezcla resultados y devuelve un subconjunto.

### Detalle

1. Usuario abre `/book/{id}`.
2. `details.blade.php` llama `GET /api/show/{id}`.
3. Se muestra metadata (título, descripción, cover, subject).
4. Si hay sesión, puede pulsar **“Añadir a mi biblioteca”**.

---

## 4) Flujo de biblioteca y “compra”

La “compra” en MVP significa **asociar el libro al usuario** en tabla pivote `purchases`.

### Compra/guardado

1. Vista detalle envía `POST /purchase` con:
   - `api_id`
   - `title`
   - `author`
   - `cover`
   - `description`
   - `price` (0 por defecto)
2. `PurchaseController@purchase`:
   - crea/actualiza el libro en `books`
   - asocia usuario ↔ libro en `purchases` (`syncWithoutDetaching`)
3. Respuesta JSON de éxito para feedback en UI.

### Biblioteca

1. Usuario abre `/library`.
2. `library.blade.php` consume `GET /api/library`.
3. `ApiLibraryController@index` devuelve cada libro con:
   - metadatos
   - `price` en pivote
   - progreso (`current_page`, `total_pages`, `percentage_completed`)

---

## 5) Flujo de lectura y progreso

### Lectura

- Botón “📖 Leer” apunta a `/read/{book}`.
- `LibraryController@read` valida que el usuario sea dueño.
- Si el libro tiene `file_path` válido, responde archivo.
- Si no hay archivo, devuelve 404 controlado.

### Progreso

1. En biblioteca el usuario define página actual y total.
2. UI llama `POST /books/{book}/progress`.
3. `ReadingProgressController@update`:
   - valida pertenencia del libro al usuario
   - hace `updateOrCreate` en `reading_progress`
   - recalcula `%` con límite 100%
4. La UI actualiza el porcentaje en la tarjeta.

---

## Estado MVP actual

- ✅ Descubrimiento y búsqueda de libros
- ✅ Recomendados cuando no hay query
- ✅ Vista detalle por obra
- ✅ Guardado de libro a biblioteca (compra interna)
- ✅ Listado de biblioteca del usuario
- ✅ Registro/actualización de progreso de lectura
- ✅ Lectura de archivo local cuando existe `file_path`