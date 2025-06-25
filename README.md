# Simple Daily Attendance System

This is a web-based **Daily Attendance Tracking System** built using PHP and MySQL. It allows users to log their attendance status throughout the day, including events like login, breaks, powercuts, and logout. Admins can view and filter attendance across all users.

---

## Technologies Used

- PHP (Vanilla)
- MySQL
- HTML5 / CSS3
- JavaScript

---

## Folder Structure

```
/
├── attendance/                 # Attendance controllers (add/edit/delete)
├── components/
│   └── navbar/                # Reusable navbar
├── includes/
│   ├── db.php                 # Database connection
│   └── auth.php               # Auth logic
├── styles/                    # CSS files
├── index.php                  # Welcome page
├── login.php                  # User login page
├── logout.php                 # logout function
├── register.php               # User register page
├── attendancePage.php         # User attendance dashboard
├── dashboard.php              # Admin view
└── README.md
```

---

## How to Set Up

1. **Clone the repository**  
   ```bash
   git clone https://github.com/your-username/daily-attendance-system.git
   cd daily-attendance-system
   ```

2. **Import the Database**  
   Use the SQL code below to create the database and populate it.

3. **Configure Database Connection**  
   Edit `includes/db.php` and update the DB credentials:
   ```php
   $conn = new mysqli("localhost", "root", "", "attendance_system");
   ```

4. **Start XAMPP or WAMP**  
   Place the project in `htdocs/` or `www/` and access it via `http://localhost/simple-php-project/`.

---

## Database Setup SQL

```sql
-- Create database
CREATE DATABASE IF NOT EXISTS attendance_system;
USE attendance_system;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user'
);

-- Attendance entries
CREATE TABLE attendance_entries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    entry_type ENUM('Login', 'Logout', 'Break', 'Powercut', 'Away', 'Ongoing', 'Idle', 'PC/Network Issues') NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME DEFAULT NULL,
    entry_date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

---

## Dummy Data
please add one user before add those data in to the database
```sql
-- Add dummy attendance entries
INSERT INTO attendance_entries (user_id, entry_type, start_time, end_time, entry_date) VALUES
(1, 'Login',     '2025-06-20 08:00:00', NULL,                        '2025-06-20'),
(1, 'Break',     '2025-06-20 10:30:00', '2025-06-20 10:45:00',       '2025-06-20'),
(1, 'Ongoing',   '2025-06-20 11:00:00', '2025-06-20 13:00:00',       '2025-06-20'),
(1, 'Idle',      '2025-06-20 13:10:00', '2025-06-20 13:30:00',       '2025-06-20'),
(1, 'Logout',    '2025-06-20 17:00:00', NULL,                        '2025-06-20'),

(1, 'Login',     '2025-06-21 08:10:00', NULL,                        '2025-06-21'),
(1, 'Break',     '2025-06-21 10:45:00', '2025-06-21 11:00:00',       '2025-06-21'),
(1, 'Powercut',  '2025-06-21 11:15:00', '2025-06-21 11:45:00',       '2025-06-21'),
(1, 'Away',      '2025-06-21 13:00:00', '2025-06-21 13:20:00',       '2025-06-21'),
(1, 'Logout',    '2025-06-21 17:30:00', NULL,                        '2025-06-21'),

(1, 'Login',     '2025-06-22 09:00:00', NULL,                        '2025-06-22'),
(1, 'Break',     '2025-06-22 11:00:00', '2025-06-22 11:15:00',       '2025-06-22'),
(1, 'PC/Network Issues', '2025-06-22 12:00:00', '2025-06-22 12:30:00', '2025-06-22'),
(1, 'Ongoing',   '2025-06-22 13:00:00', '2025-06-22 16:00:00',       '2025-06-22'),
(1, 'Logout',    '2025-06-22 17:00:00', NULL,                        '2025-06-22'),

(1, 'Login',     '2025-06-23 08:05:00', NULL,                        '2025-06-23'),
(1, 'Idle',      '2025-06-23 10:00:00', '2025-06-23 10:30:00',       '2025-06-23'),
(1, 'Break',     '2025-06-23 11:00:00', '2025-06-23 11:20:00',       '2025-06-23'),
(1, 'Away',      '2025-06-23 12:00:00', '2025-06-23 12:30:00',       '2025-06-23'),
(1, 'Logout',    '2025-06-23 17:10:00', NULL,                        '2025-06-23');
```

---

## Features

- User login/logout system
- Add, edit, and delete attendance status
- Auto-lock editing and deleteing for previous days
- Grouped view by date
- Admin dashboard with filters and search
- Modal-based entry forms
