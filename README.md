# Taskware v2

A modern task and project management application built with Laravel 12. Organize your projects, track tasks, and stay productive with an intuitive interface.

## Features

### Project Management
- ✅ Create, edit, and delete projects
- ✅ Track project status (upcoming, in-progress, completed)
- ✅ Automatic status updates based on task completion
- ✅ Project descriptions and metadata
- ✅ File attachments support (images and documents)
- ✅ View and download project attachments

### Task Management
- ✅ Create, edit, and delete tasks
- ✅ Assign tasks to projects
- ✅ Set task priorities (low, medium, high)
- ✅ Set due dates for tasks
- ✅ Track task status (pending, in-progress, completed)
- ✅ Automatic completion timestamps
- ✅ View all tasks or filter by project

### User Features
- ✅ User registration and authentication
- ✅ Secure password management
- ✅ User profile management
- ✅ Email notification preferences
- ✅ Dashboard overview

### Notifications
- ✅ Email notifications when new projects are created
- ✅ Configurable notification preferences per user
- ✅ Queue-based email delivery for better performance

### User Interface
- ✅ Modern, responsive design
- ✅ Intuitive navigation with sidebar
- ✅ Toast notifications for user feedback
- ✅ Image preview for project attachments
- ✅ Clean, organized dashboard

## Tech Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade templates, Tailwind CSS 4, Vite
- **Database**: SQLite (development) / PostgreSQL (production)

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- SQLite (for local development) or PostgreSQL (for production)

## Quick Setup

### 1. Clone the Repository

```bash
git clone https://github.com/jodayyy/taskware-v2
cd taskware-v2
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Configure Database

Edit `.env` and set your database configuration:

```env
DB_CONNECTION=sqlite
# Or for PostgreSQL:
# DB_CONNECTION=pgsql
# DB_HOST=127.0.0.1
# DB_PORT=5432
# DB_DATABASE=taskware
# DB_USERNAME=your_username
# DB_PASSWORD=your_password
```

For SQLite (default), create the database file:

```bash
touch database/database.sqlite
```

### 4. Run Migrations

```bash
# Run database migrations
php artisan migrate
```

### 5. Build Assets

```bash
# Build frontend assets
npm run build
```

### 6. Start the Development Server

```bash
# Start Laravel development server
php artisan serve
```

### 7. Access the Application

Open your browser and navigate to:
- **Application**: http://localhost:8000
- **Register** a new account or login

## Project Structure

```
taskware-v2/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Application controllers
│   │   └── Requests/        # Form request validation
│   ├── Mail/                # Email notifications
│   └── Models/              # Eloquent models
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript files
│   └── views/               # Blade templates
├── routes/
│   └── web.php             # Web routes
└── public/                  # Public assets
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).