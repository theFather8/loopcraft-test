# Student Enrollment API

A modular RESTful API for a school management system, built with Laravel 12, for managing student enrollment and class assignments.

## Features

-   Admin authentication using Laravel Sanctum.
-   Role-based access control (Admin-only).
-   Full CRUD operations for Students and Classes.
-   Many-to-many relationship for class assignments.
-   Business logic to prevent over-enrollment and duplicate assignments.
-   Performance optimized with Eager Loading.
-   Input validation using Form Requests.
-   Comprehensive Feature and Unit tests.

## Requirements

-   PHP 8.2+
-   Composer
-   MySQL
-   Laravel 12

## Installation

1.  Clone the repository.

    ```bash
    git clone <your-repo-url>
    cd loopcraft-test
    ```

2.  Install dependencies.

    ```bash
    composer install
    ```

3.  Create a copy of the `.env.example` file and name it `.env`. Configure your database credentials in this file.

4.  Generate an application key.

    ```bash
    php artisan key:generate
    ```

5.  Run the database migrations and seeders.

    ```bash
    php artisan migrate:fresh --seed
    ```

6.  Start the development server.
    ```bash
    php artisan serve
    ```

## API Endpoints

All endpoints are prefixed with `/api/v1`.

### Authentication

-   `POST /admin/login` - Logs in an admin and returns a Sanctum token.

### Protected Endpoints (Require Admin Role)

-   `POST /admin/logout` - Logs out the authenticated admin.
-   `GET /students` - Get a list of all students.
-   `POST /students` - Create a new student.
-   `GET /students/{id}` - Get a specific student.
-   `PATCH /students/{id}` - Update a student.
-   `DELETE /students/{id}` - Delete a student.
-   `POST /students/{student}/classes/{class}` - Assign a student to a class.
-   `GET /classes` - Get a list of all classes.
-   `POST /classes` - Create a new class.
-   `GET /classes/{id}` - Get a specific class.
-   `PATCH /classes/{id}` - Update a class.
-   `DELETE /classes/{id}` - Delete a class.

## Default Admin

After running the seeders, you can log in with:

-   **Email:** `admin@example.com`
-   **Password:** `password`

## Testing

Run the test suite:

```bash
php artisan test
```
