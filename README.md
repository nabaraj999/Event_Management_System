# EventHub - Event Management System

A complete **Event Management System** built with **Laravel**, **Tailwind CSS**, and **JavaScript**.  
Supports digital ticketing, organizer dashboard, admin panel, QR code attendance tracking, Khalti payment gateway integration, and SMTP email notifications.

![EventHub Banner](https://via.placeholder.com/1200x400.png?text=EventHub+Banner)  
*(Replace with an actual project screenshot or banner)*

## Features

- Admin Panel – Full control over events, users, organizers, and system settings
- Organizer Dashboard – Create/manage events, view ticket sales, attendee lists
- User Registration & Login
- Event Creation & Management – With ticket types, pricing, capacity limits
- Digital Ticketing – Generate unique tickets with QR codes
- QR Code Attendance Scanning
- Khalti Payment Gateway Integration (Nepal)
- Email Notifications – Ticket confirmation, event reminders via SMTP
- Responsive Design – Built with Tailwind CSS
- Seeded Test Accounts for quick testing

## Tech Stack

| Layer       | Technology                  |
|-------------|-----------------------------|
| Backend     | PHP (Laravel 10/11)         |
| Frontend    | HTML, Tailwind CSS, JavaScript |
| Database    | MySQL                       |
| Payment     | Khalti (Nepal)              |
| Mail        | SMTP (e.g., Gmail, Mailtrap)|
| Assets      | Vite / npm                  |

## Mandatory Environment Setup

You **must** configure the `.env` file before running the project.

```bash
cp .env.example .env
APP_NAME=EventHub
APP_ENV=local
APP_KEY=                       # Generated automatically
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_management_system
DB_USERNAME=root
DB_PASSWORD=

# Khalti Payment Gateway (Get keys from https://khalti.com)
KHALTI_SECRET_KEY=your_secret_key_here
KHALTI_PUBLIC_KEY=your_public_key_here
KHALTI_LIVE=false                  # Set to true in production
KHALTI_RETURN_URL=http://127.0.0.1:8000/event/success
KHALTI_CANCEL_URL=http://127.0.0.1:8000/event/cancel
KHALTI_WEBSITE_URL=http://127.0.0.1:8000

# Email Configuration (e.g., Gmail SMTP with App Password)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Optional
ADMIN_SUPPORT_EMAIL=support@yourdomain.com


# 1. Clone the repository
git clone https://github.com/nabaraj999/Event_Management_System.git
cd Event_Management_System

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Generate application key
php artisan key:generate

# 5. Clear configuration cache (recommended)
php artisan optimize:clear

# 6. Run migrations and seed test data (includes test accounts)
php artisan migrate --seed

# 7. Compile frontend assets
npm run dev
# For production: npm run build

# 8. Start the development server
php artisan serve


Role,Login URL,Email,Password

Admin,
Url : http://127.0.0.1:8000/admin-login
Email : admin@example.com
Password: Nepal@1234#


Organizer,
Url : http://127.0.0.1:8000/org/login
Email : technabu2025@gmail.com
Password :ThLVL4ZehlZX


This version consolidates all essential information (installation, environment, test accounts, troubleshooting) into a single, clean, and complete `README.md` file.  
Feel free to add screenshots, a demo link, or a license file if needed! 🚀
