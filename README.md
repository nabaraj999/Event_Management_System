# Event Management System (Laravel)

A complete Event Management System built with **Laravel (PHP)**, **Tailwind CSS**, and **JavaScript**.  
Includes digital ticketing, organizer dashboard, admin panel, QR attendance, Khalti payment gateway, and SMTP email system.

---

## 🛠 Tech Stack

| Layer | Tech |
|-----|----|
| Backend | PHP (Laravel) |
| Frontend | HTML, Tailwind CSS, JavaScript |
| Database | MySQL |
| Payment | Khalti |
| Mail | SMTP |

---

# ⚠️ MANDATORY ENVIRONMENT SETUP

You **must** configure `.env` before running the project.

cp .env.example .env
🔧 Required .env Configuration
Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_management_system
DB_USERNAME=root
DB_PASSWORD=



---

# 1️⃣ .env FILE (MANDATORY)

Create `.env` file in root and paste:

```env
APP_NAME=EventHub
APP_ENV=local
APP_KEY=
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

KHALTI_SECRET_KEY=YOUR_SECRET_KEY
KHALTI_PUBLIC_KEY=YOUR_PUBLIC_KEY
KHALTI_LIVE=false
KHALTI_RETURN_URL=http://127.0.0.1:8000/event/success
KHALTI_CANCEL_URL=http://127.0.0.1:8000/event/cancel
KHALTI_WEBSITE_URL=http://127.0.0.1:8000

ADMIN_SUPPORT_EMAIL=your-support@email.com

MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=YOUR_MAIL_HOST
MAIL_PORT=465
MAIL_USERNAME=YOUR_MAIL_USERNAME
MAIL_PASSWORD=YOUR_MAIL_PASSWORD
MAIL_FROM_ADDRESS=YOUR_FROM_EMAIL
MAIL_FROM_NAME="${APP_NAME}"

