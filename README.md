# Inertiajs

Laravel 13 application using Inertia.js with Vue 3 for the frontend.

The app currently includes:

- Authentication pages for register, login, and logout
- An authenticated home page that lists users
- User search by name or email
- Paginated user results with configurable page size
- Authorization-aware UI flags for edit/delete actions
- Extra authenticated pages for `About` and `Dashboard`

## Stack

- PHP 8.3
- Laravel 13
- Inertia.js Laravel adapter
- Vue 3
- Vite
- Tailwind CSS 4
- Ziggy
- Pest
- SQLite by default

## Project Structure

```text
.
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
│   └── js/
│       ├── Pages/
│       └── app.js
├── routes/
│   └── web.php
├── tests/
├── vue-project/
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

## Main Routes

- `/login` for guest login
- `/register` for guest registration
- `/` authenticated home page with paginated users
- `/about` authenticated about page
- `/dashboard` authenticated dashboard page
- `/logout` POST route for authenticated logout

## Local Setup

### 1. Install dependencies

```bash
composer install
npm install
```

### 2. Prepare environment

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configure database

This project defaults to SQLite.

```bash
touch database/database.sqlite
php artisan migrate
```

If you want to use MySQL instead, update the `DB_*` values in `.env`.

### 4. Start development servers

Run Laravel and Vite separately:

```bash
php artisan serve
npm run dev
```

Or use the Composer helper script:

```bash
composer run dev
```

## Useful Commands

```bash
composer run dev
composer run test
npm run dev
npm run build
php artisan migrate
php artisan serve
```

## Frontend Notes

- Inertia bootstrapping lives in `resources/js/app.js`
- Vue pages live in `resources/js/Pages`
- A default layout is applied automatically when a page does not define one
- Ziggy is enabled, so named Laravel routes can be used in Vue components

## Standalone `vue-project` Folder

This repository also contains a separate `vue-project/` Vite app. It is not the main frontend used by the Laravel/Inertia application, but it can be run independently from inside that folder if needed.

## Testing

The backend test setup uses Pest.

```bash
composer run test
```

## Notes

- The home route is protected by `auth` middleware
- User search and pagination are handled in `routes/web.php`
- The app expects authentication and authorization logic to be available for user actions
