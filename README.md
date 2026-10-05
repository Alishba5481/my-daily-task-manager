# My Daily Task (Task Manager)

A task manager web app with user and admin accounts, built with PHP, MySQL and JavaScript.

## Features
- User registration and login
- Add, edit and delete tasks
- Admin login and dashboard
- Passwords stored hashed (`password_hash`)

## Tech Stack
PHP, MySQL, HTML, CSS, JavaScript (React)

## How to Run
1. Run these SQL files in MySQL, in order: `db_create.sql`, `create_tasks_table.sql`, `create_admin_table.sql`
2. Copy `db.example.php` to `db.php` and enter your MySQL password
3. Start the server: `php -S localhost:8000`
4. Open `http://localhost:8000`
