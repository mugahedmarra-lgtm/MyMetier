# MyMetier — Professional Services Marketplace

<p align="center">
  <img src="public/logo.svg" alt="MyMetier Logo" width="120" />
</p>

<p align="center">
  A modern, full-featured marketplace connecting clients with skilled professionals across Morocco.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red?logo=laravel" />
  <img src="https://img.shields.io/badge/Livewire-3.x-4e56a6?logo=laravel" />
  <img src="https://img.shields.io/badge/Filament-3.x-orange" />
  <img src="https://img.shields.io/badge/MySQL-8.0-blue?logo=mysql" />
  <img src="https://img.shields.io/badge/License-MIT-green" />
</p>

---

## 📌 Overview

**MyMetier** is a professional services marketplace platform that allows users to discover, browse, and contact skilled professionals in their region. Professionals can build rich public profiles showcasing their services, expertise, portfolio, and ratings — while clients can submit public requests, leave reviews, and save favourites.

---

## ✨ Features

### 👤 Authentication
- Secure registration and login system
- Role-based access control (Client / Professional / Admin)
- Session-safe Livewire authentication with session regeneration middleware

### 🧑‍💼 Professional Profiles
- Rich profile pages with service info, description, city/district, category
- Portfolio gallery with image uploads
- Public availability badge and estimated response time
- WhatsApp quick-contact button (one-click)
- Compact two-column responsive layout

### 🔍 Search & Filters
- Full-text search with category, city, and district filters
- URL-persisted filter state for shareable search links
- Sort by relevance, rating, or recency
- "No results" suggestions and result count display
- Skeleton loading cards for smoother UX
- Scroll-to-top on pagination

### 💬 WhatsApp Contact
- Integrated WhatsApp CTA on every professional profile
- Pre-filled message template for faster client outreach

### 📋 Public Requests
- Clients can post public service requests with category, location, and description
- Professionals can browse and respond to open requests
- Detailed request view page

### ⭐ Reviews & Favorites
- Clients can leave star ratings and written reviews
- Save professionals to a favourites list for quick access
- Review moderation via admin panel

### 🛡️ Admin Panel (Filament)
- Full Filament 3 admin dashboard
- Manage: Users, Professional Profiles, Categories, Cities, Districts, Reviews, Reports, Public Requests, Gallery
- Analytics event tracking

---

## 🛠️ Tech Stack

| Layer        | Technology          |
|--------------|---------------------|
| Framework    | Laravel 12.x        |
| Frontend     | Livewire 3.x + Blade|
| Admin Panel  | Filament 3.x        |
| Database     | MySQL 8.0           |
| Build Tool   | Vite                |
| Styling      | Tailwind CSS        |
| PHP Version  | 8.2+                |

---

## 🚀 Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL

### Steps

```bash
# 1. Clone the repository
git clone git@github.com:ayoub-hamood/MyMetier.git
cd MyMetier

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure your database in .env, then run migrations
php artisan migrate

# 7. (Optional) Seed demo data
php artisan db:seed

# 8. Build front-end assets
npm run build

# 9. Start the development server
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

---

## 🖥️ Usage

- **Clients**: Register → Browse professionals by category/city → Contact via WhatsApp or post a public request → Leave reviews
- **Professionals**: Register → Complete your profile → Manage portfolio → Monitor dashboard analytics
- **Admins**: Access `/admin` → Manage all platform data via Filament panel

---

## 📁 Project Structure (Key Directories)

```
app/
├── Filament/Resources/   # Admin panel resources
├── Livewire/             # Livewire page components
├── Models/               # Eloquent models
├── Services/             # Business logic services
resources/
└── views/livewire/       # Blade views for Livewire components
```

---

## 🗺️ Roadmap

- [ ] Email & SMS notifications
- [ ] Subscription / premium profiles
- [ ] In-app messaging system
- [ ] Mobile app (React Native)
- [ ] Multi-language support (AR / FR / EN)
- [ ] Advanced analytics dashboard for professionals
- [ ] Stripe / PayPal payment integration

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

<p align="center">Built with ❤️ using Laravel · Livewire · Filament</p>
