# Inertiajs

Laravel 13 application using Inertia.js with Vue 3 for the frontend.

The app currently includes:

- Authentication pages for register, login, and logout
- An authenticated home page that lists users
- User search by name or email
- Paginated user results with configurable page size
- Authorization-aware UI flags for edit/delete actions
- Extra authenticated pages for `About` and `Dashboard`
- A user edit page for profile, role, status, bio, avatar, and permission updates
- Spatie-based user permissions for `edit`, `delete`, and `export`

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

## Backend Packages

- `laravel/framework` for the Laravel application core
- `inertiajs/inertia-laravel` for Laravel-to-Inertia responses
- `tightenco/ziggy` for named Laravel routes in Vue
- `spatie/laravel-permission` for user permissions
- `maatwebsite/excel` for export features
- `laravel/tinker` for local shell access

## Frontend Packages

- `vue` for the frontend framework
- `@inertiajs/vue3` for Inertia page rendering and forms
- `vite` for the asset pipeline
- `@vitejs/plugin-vue` for Vue SFC support in Vite
- `laravel-vite-plugin` for Laravel/Vite integration
- `tailwindcss` and `@tailwindcss/vite` for styling
- `axios` for HTTP requests
- `lodash` for utility helpers such as debounce
- `vue-toastification` for toast notifications
- `concurrently` for running the local development processes together

## Dev and Test Packages

- `pestphp/pest` and `pestphp/pest-plugin-laravel` for testing
- `laravel/pint` for PHP formatting
- `laravel/pail` for log tailing
- `fakerphp/faker` for factories and fake data
- `mockery/mockery` and `nunomaduro/collision` for local development and testing

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
- `/users/{user}/edit` authenticated user edit page
- `/logout` POST route for authenticated logout

## Local Setup

### 1. Install PHP and Node dependencies

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
php artisan db:seed --class=PermissionSeeder
php artisan storage:link
```

If you want to use MySQL instead, update the `DB_*` values in `.env`.

### 4. Optional one-command setup

You can also use the Composer setup script:

```bash
composer run setup
```

This installs PHP dependencies, prepares `.env`, generates the app key, runs migrations, installs Node dependencies, and builds frontend assets.

### 5. Start development servers

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
php artisan db:seed --class=PermissionSeeder
php artisan storage:link
php artisan serve
```

## Frontend Notes

- Inertia bootstrapping lives in `resources/js/app.js`
- Vue pages live in `resources/js/Pages`
- A default layout is applied automatically when a page does not define one
- Ziggy is enabled, so named Laravel routes can be used in Vue components
- Toast notifications are provided through `vue-toastification`
- The dashboard uses Inertia navigation for filtering and pagination
- The user edit page uses Inertia form submission with nested `permissions` checkbox state

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
- User edit/update logic lives in `app/Http/Controllers/UserController.php`
- User permissions are backed by Spatie Laravel Permission tables and the `PermissionSeeder`
- Avatar URLs are exposed through the `User` model accessor, while uploaded files are stored on the `public` disk
