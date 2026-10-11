# Student Registration System

![License: MIT](https://img.shields.io/badge/License-MIT-green)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)

A **light‑weight, role‑based** web application that lets students browse available courses, register for them, and gives administrators full CRUD control over the course catalogue. Built with **plain PHP**, **PDO**, **Bootstrap 5**, and **vanilla JavaScript**—no Composer dependencies—so it runs out‑of‑the‑box on any XAMPP/LAMP stack.

---

## Table of Contents
- [Features](#features)
- [Demo Account Credentials](#demo-account-credentials)
- [Prerequisites](#prerequisites)
- [Installation & Setup](#installation--setup)
- [Project Structure Overview](#project-structure-overview)
- [Running the Application](#running-the-application)
- [User Guides](#user-guides)
  - [Student Workflow](#student-workflow)
  - [Administrator Workflow](#administrator-workflow)
- [Security & Best Practices](#security--best-practices)
- [Testing Checklist](#testing-checklist)
- [Report & Documentation](#report--documentation)
- [Extending the Project](#extending-the-project)
- [License](#license)

---

## ⭐ Features
| Feature | Description |
|---|---|
| **Responsive UI** | Bootstrap 5 works on desktops, tablets and phones. |
| **Role‑Based Access** | `admin` can manage courses; `student` can enroll and view personal registrations. |
| **Secure Authentication** | Passwords stored with `password_hash()`; sessions regenerated on login. |
| **CRUD for Courses** | Admin can **C**reate, **R**ead, **U**pdate and **D**elete courses via a clean UI. |
| **Enrollment Logic** | Automatic decrement of `available_places`; duplicate‑enrollment prevention. |
| **Prepared Statements** | All DB interactions use PDO prepared statements → SQL‑injection safe. |
| **Graceful Error Handling** | User‑friendly alerts and server‑side validation. |
| **Exportable SQL** | `database.sql` contains schema and demo data for quick bootstrap. |

---

## 👤 Demo Account Credentials
| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@example.com` | `admin123` |
| **Student** | `student1@example.com` | `student1` |

> Use these accounts to explore both sides of the application. Feel free to register additional users.

---

## 🛠 Prerequisites
- **XAMPP** (or any Apache + MySQL + PHP stack) – PHP 7.4 or newer is recommended.  
- **phpMyAdmin** (or any MySQL client) to import the database.  
- A modern browser (Chrome / Edge / Firefox / Safari).

---

## 📦 Installation & Setup
1. **Copy the project** into your web‑root: