# Project Guidelines — LawyerConnect

This is a Laravel 13 + Tailwind CSS v4 + Blade application for an Online Lawyers
Application Website. The repository contains a complete customer/lawyer/admin
system with appointment booking, ratings, and notifications.

## Development Setup

```bash
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

## Architecture Notes

- **Auth**: Custom `AuthController` (no Laravel Breeze/Jetstream). Roles are
  stored on the `users.role` column (`customer`, `lawyer`, `admin`).
- **Middleware**: `lawyer` and `admin` aliases registered in `bootstrap/app.php`.
  Lawyers must also have `is_approved = true` to log in.
- **Database**: SQLite by default. Switch to MySQL via `.env` for production.
- **CSS**: Tailwind v4 with custom theme tokens (primary blue + accent gold)
  defined in `resources/css/app.css` under `@theme`.
- **JS**: No framework — vanilla JS in `public/js/app.js` (built from
  `resources/js/app.js`).

## Code Conventions

- All comments must be in **English**.
- Controller method names use camelCase (`storeRegistration`, `editProfile`).
- Route names use dot notation (`admin.lawyers.approve`).
- Models expose small helper methods (`isLawyer()`, `isApproved()`,
  `formattedDateTime()`) instead of inline conditionals in views.
- Validation rules live in the controller action that handles the request.

## Appointment Booking Rules

- A customer may have **only one active (pending or approved)** appointment with
  a given lawyer at any time.
- The `lawyers/show` page detects an existing active appointment and replaces
  the "Book Appointment" button with a "View My Appointment" link to the
  existing appointment.
- The `appointments.create` and `appointments.store` routes enforce this rule
  server-side too — even direct URL access is refused and the user is
  redirected to their existing active appointment with an `info` flash message.
- A customer can book a new slot with the same lawyer only after the previous
  appointment is `rejected`, `cancelled`, or `completed`. (Completed
  appointments are considered resolved.)

## Default Seed Accounts

| Role     | Email             | Password     |
|----------|-------------------|--------------|
| Admin    | admin@lawyers.com | admin123     |
| Lawyer   | ahmed@lawyer.com  | lawyer123    |
| Customer | ali@gmail.com     | customer123  |

## Common Commands

```bash
php artisan migrate --seed         # Reset DB and reseed
php artisan serve                  # Dev server on :8000
npm run dev                        # Watch CSS during development
npm run build                      # Compile CSS for production
php artisan route:list             # Inspect registered routes
php artisan tinker                 # REPL for DB inspection
```
