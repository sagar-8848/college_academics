# 🎓 Student Information Management System

---

## 📌 Project Overview

This system provides a **secure, role-based platform** to manage all core academic operations of an educational institution — from student enrollment and faculty management to examination scheduling and result generation.

Built following Django's **MVT (Model-View-Template)** architecture, the application enforces strict role-based access control across three user types: Administrator, Faculty, and Student. Each role sees only what it's allowed to, keeping data secure and the interface clean.

### Key Highlights
- **3-tier role system** — Admin, Faculty, Student with isolated permissions
- **Automatic grade calculation** — Results compute grades (A+ to F) based on percentage
- **Full CRUD** across 7 modules with search and pagination
- **Relational PostgreSQL schema** with properly defined foreign keys and constraints
- **Responsive UI** powered by Bootstrap 5

---

## ✨ Features

### 🔐 Authentication & Security
- Session-based login/logout
- Django's built-in authentication system
- Custom permission decorators for view-level protection
- Role-specific sidebar menus (hidden based on user role)
- Students can only access their own academic records

---

### 👥 Role-Based Access Control

| Feature | 👑 Admin | 👨‍🏫 Faculty | 👨‍🎓 Student |
|---|---|---|---|
| Dashboard Analytics | ✅ Full | ✅ Limited | ✅ Personal |
| Manage Students | ✅ CRUD | 👁️ View Only | ❌ |
| Manage Courses | ✅ CRUD | 👁️ View Only | ❌ |
| Manage Subjects | ✅ CRUD | 👁️ View Only | ❌ |
| Manage Faculty | ✅ CRUD | ❌ | ❌ |
| Manage Enrollments | ✅ CRUD | ❌ | 👁️ Own Only |
| Manage Exams | ✅ CRUD | ✅ CRUD | ❌ |
| Manage Results | ✅ CRUD | ✅ CRUD | 👁️ Own Only |

---

### 📚 Modules

**Student Management** — Add, edit, delete, and search students. Includes roll number, semester, contact info, and linked user accounts.

**Course Management** — Define courses with name, duration, and description. Subjects are linked per course.

**Subject Management** — Subjects carry subject code, credit hours, assigned faculty, and parent course.

**Faculty Management** — Manage faculty members with department, email, and contact details.

**Enrollment Management** — Enroll students into subjects. Prevents duplicate enrollments via database-level unique constraint.

**Examination Management** — Schedule exams with type, date, and total marks per subject.

**Result Management** — Record marks and auto-calculate grades using a percentage-based system. Results are unique per student-exam-subject combination.

---

### 📊 Dashboards

| Admin Dashboard | Faculty Dashboard | Student Dashboard |
|---|---|---|
| Total Students | Exam Overview | Personal Profile |
| Total Courses | Manage Exams | My Enrollments |
| Total Subjects | Manage Results | My Results |
| Total Faculty | — | — |
| Total Enrollments | — | — |
| Total Exams | — | — |
| Quick Action Buttons | — | — |

---

## 🗄 Database Design

The system uses **PostgreSQL** with properly normalized tables and relational integrity.

```
┌─────────────┐       ┌─────────────┐       ┌─────────────┐
│   courses   │──────<│   subjects  │>──────│  faculties  │
└─────────────┘       └──────┬──────┘       └─────────────┘
                             │
              ┌──────────────┼──────────────┐
              │              │              │
        ┌─────▼────┐   ┌─────▼────┐   ┌────▼──────┐
        │  exams   │   │enrollments│  │  results  │
        └─────┬────┘   └─────┬────┘   └────┬──────┘
              │              │              │
              └──────────────▼──────────────┘
                         ┌────────┐
                         │students│
                         └────────┘
```

### Grade Calculation Logic

```
Percentage ≥ 90%  →  A+
Percentage ≥ 80%  →  A
Percentage ≥ 70%  →  B
Percentage ≥ 60%  →  C
Percentage ≥ 50%  →  D
Percentage < 50%  →  F
```

Grade is automatically saved when a result record is created or updated.

---

## 🛠 Technology Stack

| Layer | Technology | Purpose |
|---|---|---|
| Language | Python 3.13 | Core programming language |
| Backend Framework | Django 6.x | MVT web framework |
| Database | PostgreSQL | Relational data storage |
| ORM | Django ORM | Database abstraction |
| Frontend | Bootstrap 5 | Responsive UI components |
| Markup | HTML5 | Template structure |
| Styling | CSS3 | Custom styling |
| Interactivity | JavaScript | Client-side behavior |
| DB Driver | psycopg2-binary | PostgreSQL adapter |

---

## 📂 Project Structure

```
student_mangement_system/
│
├── accounts/               # Authentication (login, logout, sessions)
├── students/               # Student module (model, views, forms, urls)
├── faculties/              # Faculty module
├── courses/                # Course module
├── subjects/               # Subject module (linked to Course & Faculty)
├── enrollments/            # Enrollment module (Student ↔ Subject)
├── exams/                  # Exam module (linked to Subject)
├── results/                # Result module (auto-grade calculation)
│
├── config/                 # Project settings, root URLs, WSGI/ASGI
│   ├── settings.py
│   ├── urls.py
│   ├── wsgi.py
│   └── asgi.py
│
├── templates/
│   ├── partials/           # Navbar, sidebar, footer
│   ├── shared/             # Reusable form, pagination, confirm-delete templates
│   ├── students/
│   ├── faculties/
│   ├── enrollments/
│   └── admin_dashboard.html
│
├── static/                 # CSS, JS, images
├── media/                  # User-uploaded files
├── manage.py
└── requirements.txt
```

---

## ⚙️ Installation Guide

### Prerequisites
- Python 3.10+
- PostgreSQL 14+
- pip

---

### 1. Clone the Repository

```bash
git clone https://github.com/sagar-8848/college-academic.git
cd college-academic/Applied-Programming/Student-Information-Management-System
```

---

### 2. Create & Activate Virtual Environment

```bash
# Create
python -m venv venv

# Activate (Windows)
venv\Scripts\activate

# Activate (Linux / macOS)
source venv/bin/activate
```

---

### 3. Install Dependencies

```bash
pip install -r requirements.txt
```

---

### 4. Configure PostgreSQL

Create a database in PostgreSQL:

```sql
CREATE DATABASE student_management_db;
```

Then update `config/settings.py`:

```python
DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.postgresql',
        'NAME': 'student_management_db',
        'USER': 'your_postgres_username',
        'PASSWORD': 'your_postgres_password',
        'HOST': 'localhost',
        'PORT': '5432',
    }
}
```

---

### 5. Apply Migrations

```bash
python manage.py makemigrations
python manage.py migrate
```

---

### 6. Create a Superuser (Optional)

```bash
python manage.py createsuperuser
```

---

### 7. Run the Server

```bash
python manage.py runserver
```

Open your browser at:

```
http://127.0.0.1:8000/
```

---

## 🔑 Default Login Credentials

> ⚠️ Change these passwords before deploying to any live environment.

### 👑 Administrator
```
Username : admin
Password : admin@nepal
```

### 👨‍🏫 Faculty
```
Username : faculty1
Password : test4fac
```

### 👨‍🎓 Student
```
Username : newson1
Password : password
```

---

## 📸 Screenshots

> *(Add screenshots of your application here)*

| Page | Description |
|---|---|
| Login Page | Secure login screen for all roles |
| Admin Dashboard | Full analytics with quick action buttons |
| Faculty Dashboard | Exam and result management overview |
| Student Dashboard | Personal academic profile |
| Student Module | CRUD with search and pagination |
| Course Module | Course listing and management |
| Enrollment Module | Enrollment management table |
| Examination Module | Exam scheduling interface |
| Result Module | Grade auto-calculation display |

---

## 🚀 Future Improvements

- [ ] **Email Notifications** — Notify students of new results and exam schedules
- [ ] **Attendance Management** — Track and report student attendance
- [ ] **Timetable Management** — Visual weekly class schedule
- [ ] **Password Reset via Email** — Self-service password recovery
- [ ] **Student Profile Pictures** — Photo upload with media management
- [ ] **Export Reports** — Download results as PDF or Excel
- [ ] **REST API** — Django REST Framework integration for mobile/SPA clients
- [ ] **Docker Deployment** — Containerized setup with docker-compose
- [ ] **Cloud Hosting** — Deploy to AWS / Railway / Render
- [ ] **Mobile Application** — Cross-platform mobile client

---

## 📖 What I Learned

Building this project gave me hands-on experience with:

- **Django MVT Architecture** — How models, views, and templates wire together in a real project
- **PostgreSQL Schema Design** — Designing normalized tables with FKs, unique constraints, and `on_delete` behavior
- **Role-Based Access Control** — Implementing custom decorators and session-based permission checks
- **Django ORM** — Using ForeignKey, OneToOneField, and custom `save()` overrides (auto-grade calculation)
- **CRUD with Forms** — ModelForms, form validation, and clean view-template separation
- **Bootstrap 5 UI** — Building a fully responsive, role-aware dashboard interface
- **Django Authentication** — User model extension, login/logout, session management

---

## 👨‍💻 Developer

**Sagar Suwal**
BCS.IT — 6th Semester
Himalayan College of Management
Applied Programming Project | 2026


---

## 📄 License

This project was developed for educational purposes as part of the BCS.IT Applied Programming course at Himalayan College of Management.

You are free to use, study, and modify this project for learning and academic purposes.

---


**⭐ If this project helped you, consider giving it a star on GitHub!**
