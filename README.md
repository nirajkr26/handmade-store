# Handmade Marketplace 🎨

A modern, role-based marketplace platform built with **Laravel 12.x**, designed for artists and crafters to list products and for buyers to purchase unique handmade goods.

## ✨ Features

- **🛍️ Marketplace**: Browse, search, and filter products by categories.
- **🏷️ Seller Management**: dedicated tools for sellers to manage listings (CRUD) and track inventory.
- **📦 Order System**: 
    - Buyers can place orders with "Buy Now" functionality.
    - Sellers can track received orders and update status (Processing, Shipped, Delivered).
    - Integrated logic for stock reduction and restoration on cancellation.
- **💬 Real-time Chat**: Two-way communication between buyers and sellers with conversation grouping.
- **📧 Email Notifications**: Automatic email triggers for new orders and received messages.
- **💅 Premium UI**: Modern glassmorphism design, responsive layouts, and smooth animations using Tailwind CSS.

## 🛠️ Tech Stack

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Frontend**: Blade, Tailwind CSS, AlpineJS
- **Database**: MySQL (Compatible with XAMPP)
- **Auth**: Laravel Breeze
- **Build Tool**: Vite

## 🚀 Getting Started

### 1. Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL (XAMPP/MAMP/Docker)

### 2. Installation
Clone the repository and enter the directory:
```bash
cd handmade-marketplace
```

Install dependencies:
```bash
composer install
npm install
```

### 3. Configuration
Copy the environment file:
```bash
cp .env.example .env
```

Generate the application key:
```bash
php artisan key:generate
```

Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=handmade_marketplace
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Setup
Create the database in your MySQL client, then run migrations and seeders:
```bash
php artisan migrate --seed
```

### 5. Storage & Assets
Link the storage to display product images:
```bash
php artisan storage:link
```

Build the frontend assets:
```bash
npm run build
```

### 6. Running the Application
Start the development servers:
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Visit the app at [http://127.0.0.1:8000](http://127.0.0.1:8000).


## 📧 Mail Setup
To test email notifications, configure your SMTP settings in `.env`. For local testing, you can use [Mailtrap](https://mailtrap.io/) or similar:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
...
```

---
Made with ❤️ for Artisans.
