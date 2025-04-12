<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Document Delivery System

This is a document management system built with Laravel. It handles invoices, documents, and other business processes.

## Route Organization

The routes in this application are organized into separate files for better maintainability:

-   **web.php**: Main entry point and authentication routes
-   **invoices.php**: Invoice management routes
-   **addocs.php**: Additional documents management routes
-   **master.php**: Master data management routes (departments, suppliers, projects)
-   **settings.php**: System settings and user management routes

## Features

-   User authentication with username/email
-   Invoice management
-   Document management
-   Activity logging
-   Role-based access control
-   Toast notifications (Toastr)
-   Confirmation dialogs (SweetAlert2)

## Installation

```bash
# Clone the repository
git clone https://github.com/yourusername/document-delivery-system.git

# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file and run migrations
php artisan migrate

# Start development server
php artisan serve
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
