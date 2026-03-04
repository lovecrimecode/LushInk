LushInk is a **Laravel-based web application designed for discovering, saving, and reading books**.

The platform integrates with the **OpenLibrary API** to search and retrieve book metadata while maintaining an **internal user library system** where users can add books to their personal collection.

The application currently focuses on delivering a **clean MVP architecture** with a separation between:

- **HTML page controllers**
- **API controllers returning JSON**
- **Service layer handling external API integration**

---

## Core Concept

LushInk works as a **metadata-driven book discovery platform**.

OpenLibrary provides book metadata such as:

- title
- author
- cover
- publication year
- subjects
- description

The application stores only the metadata required for the UI and links books to users via an internal **library system**.

Actual readable content may later be provided via internally stored files.

---

## Book Discovery Model

The search experience supports **two modes**:

### 1. User Search

When a user searches for a book:

```
/book/search?q=tolkien
```

The frontend calls:

```
/api/search?q=tolkien
```

Which triggers:

```
ApiBookController
   ↓
BookApiService
   ↓
OpenLibrary Search API
```

Results are normalized before returning to the UI.

Each book object returned contains:

```
work_id
title
author
published_year
cover_url
```

---

### 2. Recommended Books (Empty Search)

If the user **does not provide a search query**, the system returns a set of **recommended books**.

Instead of returning empty results, the service:

1. Fetches trending works from OpenLibrary
2. Randomizes the results
3. Returns a subset for discovery

Flow:

```
/book/search?q=
        ↓
BookApiService::search('')
        ↓
BookApiService::index()
        ↓
OpenLibrary trending API
        ↓
shuffle() + take(20)
```

This improves UX by ensuring the search page **always displays content**, even when no query is provided.

In the UI this appears as:

```
"Libros recomendados"
```

instead of

```
"Resultados"
```

---

## Book Metadata Normalization

All external API responses are normalized into a **consistent UI schema**.

Normalized format:

```
{
  work_id: string,
  title: string,
  author: string | null,
  published_year: number | null,
  cover_url: string | null
}
```

This abstraction ensures the frontend does **not depend directly on OpenLibrary response structures**.

---

## Service Layer

All OpenLibrary integration is encapsulated inside:

```
App\Services\BookApiService
```

Responsibilities:

- Handle HTTP calls to OpenLibrary
- Retry failed requests
- Normalize responses
- Provide trending books
- Provide search results
- Provide book details

This keeps controllers thin and makes the service **unit-testable**.

---

## Testing Strategy

The project includes **unit tests for the service layer**.

Example test:

```
tests/Unit/BookApiServiceTest.php
```

Purpose:

- Verify search behavior
- Ensure empty search returns recommended books
- Mock external API calls with `Http::fake()`

Example tested behavior:

```
search('')
   ↓
calls index()
   ↓
returns trending books
```

This ensures the application does not rely on real external requests during testing.

---

## User Library Concept

Users can add books to their personal collection.

The flow:

```
Book details page
        ↓
POST /purchase
        ↓
PurchaseController
        ↓
Book created or updated locally
        ↓
Book attached to user via purchases pivot
```

Users then access their books through:

```
/library
```

The page fetches data from:

```
/api/library
```

---

## User Experience Philosophy

The interface is designed with:

- **Dark UI theme**
- **Wine accent color**
- **Card-based layout**

Books are displayed using reusable cards that include:

- cover
- title
- author
- year

Cards appear across:

```
search results
library
dashboard previews
```

---

## Development Philosophy

The project emphasizes:

- clean Laravel architecture
- separation of concerns
- service-based external integrations
- normalized API responses
- testable service logic
- progressive feature expansion

---

## Current MVP Scope

The current version supports:

- book discovery via OpenLibrary
- recommended books when search is empty
- viewing book metadata
- adding books to a user library
- listing a user's library
- reading internal book files when available

---

## Planned Future Features

Planned improvements include:

- upload and manage internal book files
- reading progress tracking
- pagination for large search results
- author metadata pages
- category and subject filtering
- improved dashboard analytics
- in-browser reading interface

---