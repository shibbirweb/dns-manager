# DNS Manager

---

This is a simple DNS manager that allows you to add, remove and list DNS records.

---

Features:

- [x] Server
    - [x] List
        - [x] Pagination
    - [x] Create
        - [x] Encrypt Password
    - [x] Update
        - [x] Encrypt Password
    - [x] Delete
    - [x] Connect to Server
        - [x] via SSH using `username` and `password`
        - [x] Can execute commands as like terminal to manage the sever
- [x] Sites
    - [x] Create
        - [x] Create site directory in server
    - [x] Update
        - [x] Update site directory in server
    - [x] Delete
    - [x] List
        - [x] Pagination
    - [x] WP Magic Login
        - [x] One time usable generated token
        - [x] Regenerate Secret Key
        - [x] Implement Hashing to verify token
        - [x] API Endpoint to verify token from WP Plugin
- [x] Cloudflare DNS
    - [x] Connect to Cloudflare using API Token
    - [x] List DNS Records
    - [x] Create DNS Record

---

Technologies:

- [x] Laravel 11
- [x] Inertia.js with React (TypeScript)
- [x] TailwindCSS

---

Requirements:
- PHP 8.3
- Composer
- Node.js
- NPM
---

Installation:

1. Clone/download the repository
2. Run `composer install`
3. Run `php artisan key:generate`
4. Run `php artisan migrate`
5. Run `php artisan db:seed`
6. Run `npm install`
7. Run `npm run build`
8. Run `php artisan serve`
9. Visit `http://localhost:8000`

---

Credentials:

- Email: `admin@example.com`
- Password: `password`
