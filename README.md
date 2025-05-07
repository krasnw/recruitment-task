<div align="center">
<h3>Aplikacja rekrutacyjna — formularz wieloetapowy z walidacją i backendem</h3>
<p>

[![Vue.js](https://img.shields.io/badge/Vue.js-4FC08D?logo=vuedotjs&logoColor=fff)](#) [![Symfony](https://img.shields.io/badge/Symfony-black?logo=symfony)](#) [![Postgres](https://img.shields.io/badge/PostgreSQL-%23316192.svg?logo=postgresql&logoColor=white)](#)

</p>

<p>

[🎥 **Demo**](/demo/e2e.mp4)

</p>

</div>

Projekt przedstawia pełną implementację formularza rekrutacyjnego w technologii Vue 3.5, Symfony 6.4, z użyciem bazy danych PostgreSQL. Aplikacja została zorganizowana w architekturze mikroserwisowej i podzielona na trzy kontenery Docker (frontend, backend, baza danych), które są orkiestrowane za pomocą docker-compose.

## 🚀 Instalacja i uruchomienie

### Wymagania wstępne

- Docker
- Docker Compose

### Uruchomienie projektu

1. Uruchom kontenery

```bash
docker-compose up -d --build
```

Po uruchomieniu aplikacja będzie dostępna pod adresami:

- Frontend: `http://localhost:5173/form`
- Backend API: `http://localhost:8000`
- PostgreSQL: `localhost:5433`

## 🏗 Struktura projektu

Projekt jest podzielony na trzy główne komponenty:

### Frontend (Vue.js)

- Vue 3.5
- Vite jako narzędzie do budowania
- Vue Router do nawigacji ([ścieżki](/frontend/src/router/index.js))
- Wieloetapowy formularz z [walidacją](/frontend/src/utils/validation.js)
- Komponenty wielokrotnego użytku w folderze [Shared](/frontend/src/components/shared/)

### Backend (Symfony)

- Symfony 6.4
- API Platform dla REST API
- Biblioteki Symfony:
  - `symfony/validator` - walidacja danych
  - `symfony/serializer` - serializacja/deserializacja JSON
  - `doctrine/orm` - mapowanie obiektowo-relacyjneh
  - `api-platform/core` - REST API Framework
  - `nelmio/cors-bundle` - obsługa CORS
- Trzy endpointy API do obsługi formularza: [Plik żądań](/backend/requests.HTTP)
  - `POST /api/form` - do przesyłania danych formularza
  - `GET /api/users` - do pobierania wszystkich zapisanych danych
  - `GET /api/users/{id}` - do pobierania szczegółów konkretnego wpisu

### Baza danych

- PostgreSQL
- Migracje przez Doctrine
- Dane do logowania do bazy danych:
  - Użytkownik: `soulab_user`
  - Hasło: `soulab_password`
  - Nazwa bazy danych: `soulab_task`

## 🔧 Szczegóły techniczne

- RESTful API do przetwarzania danych formularza
- Walidacja danych na frontendzie, backendzie, i bazie danych
- Przechowywanie danych w PostgreSQL
- Docker do konteneryzacji i łatwego wdrażania
- CORS dla komunikacji między frontendem a backendem
- Użycie DTO (Data Transfer Object) do przesyłania danych między frontendem a backendem
- Przegląd danych po zatwierdzeniu formularza
- Dostęp do listy wszystkich zapisanych danych przez dedykowany endpoint API

## 📈 Propozycje rozwoju

- Dodanie autoryzacji i uwierzytelniania
- Umieszczenie tabel bazy danych w oddzielnym schemacie (nie domyślnym), i konfiguracja dostępu do nich.
- Dodanie testów jednostkowych i integracyjnych
- Dodanie walidacji unikalności email i numeru telefonu
- Adaptacja aplikacji do urządzeń mobilnych
- Dodanie i18n
