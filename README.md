
# ⚖️ Law Pro – Law Firm Management System

> A Web-Based Solution for Organizing and Managing Legal Practices  
> **Developed by:** Rahaf Ayed Alharthi, Noura Ayed Al-Qahtani, Mona Saud Al-Shahrani, Rinas Khalofa Al Ameri  
> **Supervised by:** Dr. Doaa M. Bamasoud  
> **Faculty of Computing and Information Technology – University of Bisha**

---

## 📘 Overview

**Law Pro** is a web-based legal management system tailored for law firms and independent lawyers. Designed to modernize traditional legal workflows, the platform provides an integrated solution for managing cases, clients, appointments, financial transactions, and administrative roles — all in one centralized dashboard.

This system enhances productivity, reduces errors, improves client service, and ensures secure and efficient handling of legal operations.

---

## 🎯 Key Features

### ✅ Case & Client Management
- Add, update, and track legal cases
- Secure client information storage and management
- Case filtering, searching, and status updates

### 🌐 Multilingual Support
- Full support for **Arabic 🇸🇦** and **English 🇺🇸**
- Dynamic language switching and RTL layout for Arabic

### 📅 Appointments & Scheduling
- Book and manage meetings, hearings, and consultations
- Calendar view with upcoming appointments

### 💼 Task & Workflow Automation
- Assign and monitor legal tasks
- Receive alerts for pending and urgent actions

### 💳 Financial Management
- Invoice generation and payment tracking
- Expense categorization and tax management
- Financial reporting module

### 🔐 Role-Based Access Control (RBAC)
- Distinct roles: Admin, Lawyer, Employee
- Custom permissions per role
- Secure login, session, and password management

### 📊 Reporting & Notifications
- Real-time dashboard with KPIs
- Alerts for upcoming hearings, deadlines, and urgent cases

---

## 🛠️ Technologies Used

### Backend
- PHP 7.4+ (Laravel Framework)
- MySQL Database
- Apache (via XAMPP)

### Frontend
- HTML5, CSS3 (Bootstrap)
- JavaScript, jQuery, AJAX

### Tools & Environment
- Visual Studio Code
- phpMyAdmin
- StarUML (UML Diagrams)
- Microsoft Office Suite
- Laravel Debugbar, PHPUnit

---

## 🔐 Security Features
- CSRF protection
- Password hashing (bcrypt)
- Session management
- Role-based access and permission control
- Sensitive data encryption

---

## 📁 Project Structure (Laravel)
```
app/            → Application logic (controllers, models)
resources/views/→ Blade templates (UI)
routes/web.php  → Application routing
public/         → Public assets (CSS, JS)
database/       → Migrations, seeders
config/         → Configuration files
```

---

## 📱 Future Enhancements
- 📱 Mobile App (Android/iOS)
- 📩 Email & Calendar Integration
- 🧠 AI-Based Legal Analytics
- 🗂️ Legal Document Uploads
- 💬 Internal Chat System
- 📊 Advanced Reporting Dashboard

---


---

## 👥 Demo User Credentials

The system includes four predefined user types for testing:

| Role        | Email                     | Password        |
|-------------|---------------------------|-----------------|
| Super Admin | superadmin@gmail.com      | @Super12345     |
| Admin       | admin@gmail.com           | @Admin12345     |
| Lawyer      | lawyer@gmail.com          | @Lawyer12345    |
| Employee    | employee@gmail.com        | @Employee12345  |


## 🚀 Getting Started

### Prerequisites
- PHP 7.4+
- Composer
- MySQL
- Node.js & npm (for asset compilation)
- XAMPP (or any Apache server)

### Installation Steps
```bash
git clone https://github.com/Ammar-1993/lawprosystem.git
cd lawpro
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Access the system at: **http://127.0.0.1/lawprosystem**

---

## 🧪 Testing
- Feature testing using Laravel's built-in `PHPUnit`
- Browser testing via Chrome DevTools
- Backend and database testing through XAMPP and phpMyAdmin

---

## 🤝 Authors & Contributors
- **Rahaf Ayed Alharthi** – Backend & Database
- **Noura Ayed Al-Qahtani** – UI/UX & Testing
- **Mona Saud Al-Shahrani** – Documentation & Research
- **Rinas Khalofa Al Ameri** – System Design & Deployment
- **Supervisor:** Dr. Doaa M. Bamasoud

---

## 📄 License
This project is part of a graduation thesis and currently licensed for educational and academic use. For commercial licensing or collaboration, please contact the authors or Bisha University’s Department of Information Systems.

---

## 🌐 Acknowledgements
We extend our sincere thanks to our supervisor, faculty members, families, and peers who supported this project and inspired our success.
