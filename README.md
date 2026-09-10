# LawyerConnect — Online Lawyers Application Website

A web platform that connects customers with verified lawyers across Pakistan.
Customers can search lawyers by specialization and city, view lawyer profiles,
book appointments online, and rate completed appointments.

Built with **Laravel 13**, **Tailwind CSS v4**, and **Blade** templates.

---

## Features

### Customer
- Register / login / logout
- Forgot password (email-based reset link)
- Edit profile and change password
- Search lawyers by name, city, specialization
- Sort lawyers by rating / experience / fee
- View lawyer profile (qualification, fee, availability, rating)
- Book an appointment at a preferred date/time
- Cancel pending or approved appointments
- View appointment history
- Rate lawyers after a completed appointment

### Lawyer
- Register with extra professional fields (bar council number, qualification, fee, availability)
- Account goes through admin approval before login is allowed
- Personal dashboard with stats (total / pending / approved / completed)
- Manage appointments (approve / reject / mark completed)
- Edit profile (specialization, fee, available days/time, contact info)
- In-app notifications for new appointment requests and cancellations

### Admin
- Dashboard with key statistics (customers, lawyers, appointments)
- Approve / reject pending lawyer registrations
- Manage customers (search / delete)
- View all appointments across the platform
- Manage service categories (add / delete)
- View and delete contact-form messages

### Public
- Home page with featured lawyers and specializations
- About / Privacy Policy / Terms pages
- Contact form (submissions land in admin inbox)
- Responsive layout (mobile + desktop)

---

## Tech Stack

| Layer    | Technology                                  |
|----------|---------------------------------------------|
| Backend  | Laravel 13 (PHP 8.3)                        |
| Frontend | Blade + Tailwind CSS v4 + vanilla JS        |
| Database | SQLite (default) / MySQL (production-ready) |
| Build    | Vite                                        |
| Auth     | Laravel's built-in auth + custom controllers |

---

## Installation (Local Development)

### Prerequisites
- PHP 8.3+
- Composer
- Node.js + npm
- SQLite (or MySQL if you prefer)

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/UmarBuild/lawyers-website.git
cd lawyers-website

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies and build assets
npm install
npm run build

# 4. Configure environment
cp .env.example .env
php artisan key:generate

# 5. Run migrations + seeders (creates tables, admin, sample lawyers)
php artisan migrate --seed

# 6. Start the development server
php artisan serve
# App is now available at http://localhost:8000
```

### Default Login Credentials

| Role     | Email             | Password     |
|----------|-------------------|--------------|
| Admin    | admin@lawyers.com | admin123     |
| Lawyer   | ahmed@lawyer.com  | lawyer123    |
| Customer | ali@gmail.com     | customer123  |

---

## Production Deployment

For production, switch the database to MySQL by editing `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lawyerconnect
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

Then run:

```bash
php artisan migrate --seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

Configure your web server (Apache/Nginx) to point the document root at `public/`.

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php         # Admin panel
│   │   ├── AppointmentController.php   # Appointment booking / cancel / rate
│   │   ├── AuthController.php          # Register / login / forgot password
│   │   ├── HomeController.php          # Home / contact / customer profile
│   │   └── LawyerController.php        # Lawyer panel + search
│   └── Middleware/
│       ├── AdminMiddleware.php
│       └── LawyerMiddleware.php
├── Models/
│   ├── Appointment.php
│   ├── ContactMessage.php
│   ├── Notification.php
│   ├── Service.php
│   └── User.php
database/
├── migrations/                          # All schema definitions
└── seeders/
    ├── DatabaseSeeder.php               # Canonical seeder
    └── ServiceSeeder.php                # Empty stub (kept for compat)
resources/
├── css/app.css                          # Tailwind entry + theme
├── js/app.js                            # Source JS (built to public/js/app.js)
└── views/                               # Blade templates
routes/
└── web.php                              # All HTTP routes
```

---

## Documentation

The project follows the requirements defined in:

- `Project Specification (Lawyers Website) -OST.docx` — project standards plan
- `PHP-Lawyers_Website.docx` — module-level feature spec

Deliverables covered: registration, lawyer panel, search by location/specialization,
view profile, book appointment, login, admin pages.

---

## License

This project is developed as part of an academic eProject submission. All rights
reserved to the project author.
