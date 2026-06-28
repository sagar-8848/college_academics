# 🛍️ SimpleShop — Mini E-Commerce Web Application

> **Subject:** Web Technology
> **Semester:** BSc IT, 6th Semester
> **Submitted By:** Sagar Suwal — [@sagar-8848](https://github.com/sagar-8848)

---

## 📌 Project Overview

SimpleShop is a fully functional secure mini e-commerce web application built with PHP, MySQL, Bootstrap 5, and JavaScript. It covers user authentication, product management, cart operations with atomic transactions, and order tracking with a live countdown timer.

---

## 🔐 Demo Credentials

Visitors can log in and explore the full application using these credentials:

| Field    | Value                  |
|----------|------------------------|
| Email    | demo@simpleshop.com    |
| Password | password            |

---

## ⚙️ Setup Instructions

### Requirements
- XAMPP (Apache + MySQL running)
- phpMyAdmin

### Step 1 — Database Setup
- Open **phpMyAdmin**
- Click the **SQL** tab
- Run the contents of `setup.sql`
- This creates the `shop` database, all 6 tables, 16 products, and the demo user

### Step 2 — Run the Project
- Copy this folder to: `C:/xampp/htdocs/SimpleShop/`
- Open browser and visit: `http://localhost/SimpleShop/`

---

## 📁 File Structure
SimpleShop/

├── db.php              ← Shared PDO database connection

├── index.php           ← Login and signup entry portal

├── header.php          ← Reusable Bootstrap navbar

├── footer.php          ← Reusable footer with JS scripts

├── home.php            ← Product grid with filter and sort

├── cart.php            ← Cart management and checkout

├── about.php           ← Company profile page

├── orders.php          ← Order history with countdown timer

├── style.css           ← Custom styles

├── script.js           ← Swiper, timer, alert dismiss

├── setup.sql           ← Run this in phpMyAdmin first

├── images/             ← Product and banner images

└── user/

├── auth.php        ← Session and cookie access controller

├── signup.php      ← Registration handler

├── login.php       ← Login handler

├── logout.php      ← Logout handler

└── confirm.php     ← Email verification

---

## ✨ Features

- Secure registration with 6-digit email verification
- Login with Remember Me (persistent cookie sessions)
- Product grid with category filter and price sort
- Real-time stock badges (In Stock / Low Stock / Out of Stock)
- Cart with PDO atomic transaction checkout
- Order history with live delivery countdown timer
- Fully responsive Bootstrap 5 UI

---

## 🛠️ Built With

PHP 8 · MySQL · Bootstrap 5 · Bootstrap Icons · Swiper.js · Vanilla JavaScript · XAMPP

