# Complete Point-of-Sale System — CodeIgniter 4

Student: Paul Terence Guadalupe  
Section: TC23

## Features

- Secure staff login/logout with hashed passwords and regenerated sessions
- Authentication filter protecting every management and sales page
- Product CRUD, stock tracking, and prepared JPG/PNG product images
- Customer full CRUD
- Staff full CRUD, hashed passwords, and prepared avatars
- Transaction-safe sale recording with stock validation and automatic stock deduction
- Sales history with product, customer, staff, quantity, total, and date
- CSRF-protected forms, validated uploads, escaped output, migrations, seeder, and SQL export

## Requirements

PHP 8.2+, Composer, MySQL/MariaDB, and PHP extensions `intl`, `mbstring`, `mysqli`, and `gd`.

## Installation

1. Run `composer install`.
2. Copy `env` to `.env`.
3. Change the database name in `.env` to `complete_pos` and enter your MySQL credentials.
4. Either import `database/complete_pos.sql` in phpMyAdmin, or run:

   ```bash
   php spark migrate
   php spark db:seed PosSeeder
   ```

5. Make sure `public/uploads` is writable.
6. Run `php spark serve` and open `http://localhost:8080`.

Demo login: `admin` / `password123`

For hosting, point the domain document root to `public`, configure production database credentials, use HTTPS, and replace the demo password immediately.

## Required testing

- Logged-out visits to `/products`, `/customers`, `/users`, and `/sales` redirect to `/login`.
- Correct credentials open the dashboard; incorrect credentials show a generic error.
- Product, customer, and staff create/edit/delete workflows function.
- JPG/PNG files up to 2 MB are accepted; invalid uploads are rejected.
- A valid sale reduces stock and appears in history.
- A sale exceeding available stock is rejected without changing stock.
- Logout destroys the session and returns to `/login`.
