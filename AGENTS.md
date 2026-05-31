# AGENTS.md — Sistem Bimbel

**Laravel 11** tutoring management system (door-to-door). Blade + Tailwind 3 + Alpine.js + Vite.

## Setup
- PHP 8.2+, MySQL 8.0 on port **3307** (Laravel Herd default)
- `composer install && npm install`
- `cp .env.example .env && php artisan key:generate`
- Edit `.env` DB port to 3307, then `php artisan migrate --seed`
- `php artisan storage:link`
- `npm run dev` (Vite HMR) + Herd or `php artisan serve`

## Test Users (from seeder)
| Role   | Email                 | Password |
|--------|-----------------------|----------|
| Admin  | admin@bimbel.com      | password |
| Tutor  | ahmad.tutor@bimbel.com | password |
| Client | rina.client@bimbel.com | password |

## Commands
| Task | Command |
|------|---------|
| Tests | `vendor/bin/phpunit` |
| Lint | `vendor/bin/pint` |
| Vite dev | `npm run dev` |
| Vite build | `npm run build` |
| Deploy | `deploy.bat` (build + commit + push main) |
| Custom | `php artisan app:recalculate-payments` |

## Architecture
- **All web routes**: `routes/web.php` — grouped by role middleware `role:admin|tutor|client`
- **RoleMiddleware** registered as `role` alias in `bootstrap/app.php`
- **Config**: `config/bimbel.php` (pricing: client Rp50k/session, tutor Rp40k/session)
- **Profit**: Company margin Rp10k/session; salary uses `updateOrCreate` to avoid duplicates
- **Attendance**: GPS via Haversine (100m threshold), requires photo, statuses: `hadir` / `pindah_lokasi`
- **Quality**: 5 criteria (1-5 scale), tiers: Junior (<4.0) → Regular (4.0-4.5) → Senior (4.5-4.8) → Master (>4.8)
- **Timezone**: `Asia/Jakarta`, locale `id`
- **Queue/Cache/Session**: sync/file drivers in `.env` (config defaults to database)

## Tests
- PHPUnit 10.5, **no project-specific tests exist** (only boilerplate)
- `DB_CONNECTION` commented out in `phpunit.xml` — tests do NOT use in-memory SQLite
- No `RefreshDatabase` trait in feature tests

## Conventions
- Layout: `resources/views/layouts/app.blade.php` — `@yield('content')`, `@stack('styles')`/`@stack('scripts')`
- Flash: `session('success')` / `session('error')`
- Blade components: `AppLayout`, `GuestLayout` in `app/View/Components/`
- Notifications: 6 types (`new_schedule`, `new_report`, `payment_due`, `salary_ready`, `quality_alert`, `upcoming_schedule`)
- Vite: `@vite(['resources/css/app.css', 'resources/js/app.js'])`

## Routes
- `routes/web.php` — main app routes (194 lines)
- `routes/auth.php` — auth (Breeze)
- `routes/console.php` — `inspire` + custom commands

## Notes
- No CI/CD pipeline; no GitHub Actions
- Scratch scripts in root (`scratch_fix_*.php`, `seed_completed_session.php`) — not part of app
- Controller layout: `app/Http/Controllers/{Admin,Tutor,Client}/` (26 controllers total)
- 14 Eloquent models, 29 migrations, 3 seeders
