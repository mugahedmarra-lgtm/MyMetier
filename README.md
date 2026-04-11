# MyMetier

MyMetier is a modern, full-featured marketplace connecting clients with skilled professionals across Morocco.

## Overview

MyMetier is a professional services marketplace platform that allows users to discover, browse, and contact skilled professionals in their region. Professionals can build rich public profiles showcasing their services, expertise, portfolio, and ratings. Clients can submit public requests, leave reviews, and save favorites.

## Tech Stack

- **Framework**: Laravel 12.x
- **Frontend**: Livewire 3.x + Blade
- **Admin Panel**: Filament 3.x
- **Database**: MySQL 8.0
- **Build Tool**: Vite
- **Styling**: Tailwind CSS
- **PHP Version**: 8.2+

## Features

- **Authentication**: Secure registration, login, and role-based access control (Client, Professional, Admin).
- **Professional Profiles**: Profiles with service info, description, location, portfolio gallery, and a WhatsApp quick-contact button.
- **Search & Filters**: Full-text search with category and location filters, sorting, and URL-persisted state.
- **Public Requests**: Clients can post service requests, and professionals can browse and respond to them.
- **Reviews & Favorites**: Clients can leave star ratings and reviews, and save professionals to a favorites list.
- **Admin Panel**: Full dashboard to manage users, profiles, categories, locations, reviews, requests, and galleries.

## Screenshots

> Note: Screenshots will be added here in the future. (See docs/screenshots/)

## Local Setup Instructions

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm
- MySQL

### Steps

1. Clone the repository:
   ```bash
   git clone git@github.com:ayoub-hamood/MyMetier.git
   cd MyMetier
   ```
2. Install PHP dependencies:
   ```bash
   composer install
   ```
3. Install Node dependencies:
   ```bash
   npm install
   ```
4. Copy environment file:
   ```bash
   cp .env.example .env
   ```
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Configure your database in `.env`, then run migrations:
   ```bash
   php artisan migrate
   ```
7. (Optional) Seed demo data:
   ```bash
   php artisan db:seed
   ```
8. Build front-end assets:
   ```bash
   npm run build
   ```
9. Start the development server:
   ```bash
   php artisan serve
   ```

Visit http://localhost:8000 in your browser.

## Project Status

Active development. Roadmap includes email/SMS notifications, premium profiles, in-app messaging, multi-language support, and payment integration.

## License

This project is licensed under the MIT License.
