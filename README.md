# 🎓 Sistem Bimbel

> Platform manajemen bimbingan belajar door-to-door berbasis Laravel 11 + Vue.js

## 🤖 AI Agent Quick Context
- **Stack**: Laravel 11 + Breeze + Blade/Tailwind + MySQL 8.0
- **Auth**: Session-based, Roles: `admin` | `tutor` | `client`
- **Status**: 🟢 Beta Ready - Core features done
- **DB**: `sistem_bimbel` @ `127.0.0.1:3307`
- **Test Users**: `admin@bimbel.com` / `password`

## ⚡ Quick Start
```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
php artisan migrate --seed
php artisan serve && npm run dev