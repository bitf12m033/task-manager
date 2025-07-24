# Task Manager

A simple and elegant Laravel-based Task Manager application with Bootstrap frontend and MySQL database.

## Features

- ✅ **Create, edit, and delete tasks**
- ✅ **Mark tasks as "To Do," "In Progress," or "Done"**
- ✅ **View tasks in a list with status color indicators**
- ✅ **Responsive Bootstrap design**
- ✅ **No login required - simple and straightforward**
- ✅ **Modern UI with hover effects and icons**

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL/MariaDB
- Laravel 10.x

## Installation

1. **Clone or download the project**
   ```bash
   git clone <repository-url>
   cd task-manager
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Set up environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit the `.env` file and update your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=task_manager
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

7. **Access the application**
   Open your browser and go to: `http://localhost:8000`

## Usage

### Viewing Tasks
- The home page displays all tasks in a card layout
- Each task shows its title, description (truncated), status badge, and creation date
- Status badges are color-coded:
  - 🟡 **To Do** (Yellow)
  - 🔵 **In Progress** (Blue)
  - 🟢 **Done** (Green)

### Creating Tasks
1. Click the "New Task" button in the navigation or on the main page
2. Fill in the task title (required)
3. Add an optional description
4. Select the initial status
5. Click "Create Task"

### Editing Tasks
1. Click the edit icon (pencil) on any task card
2. Modify the title, description, or status
3. Click "Update Task"

### Deleting Tasks
1. Click the delete icon (trash) on any task card
2. Confirm the deletion in the popup dialog

### Viewing Task Details
- Click the view icon (eye) on any task card to see full details
- The detail view shows complete information including creation and update timestamps

## Project Structure

```
task-manager/
├── app/
│   ├── Http/Controllers/
│   │   └── TaskController.php      # Handles all task operations
│   └── Models/
│       └── Task.php               # Task model with status constants
├── database/
│   ├── migrations/
│   │   └── create_tasks_table.php # Database schema
│   └── seeders/
│       └── TaskSeeder.php         # Sample data
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php      # Main layout with Bootstrap
│       └── tasks/
│           ├── index.blade.php    # Task listing page
│           ├── create.blade.php   # Create task form
│           ├── edit.blade.php     # Edit task form
│           └── show.blade.php     # Task detail view
└── routes/
    └── web.php                    # Application routes
```

## Database Schema

The `tasks` table contains:
- `id` - Primary key
- `title` - Task title (required)
- `description` - Task description (optional)
- `status` - Task status (enum: 'To Do', 'In Progress', 'Done')
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

## Customization

### Adding New Status Types
1. Update the migration file to include new enum values
2. Add constants to the Task model
3. Update the `getStatuses()` method
4. Run `php artisan migrate:fresh --seed`

### Styling Changes
- Modify the CSS in `resources/views/layouts/app.blade.php`
- Update Bootstrap classes in the view files
- Add custom CSS for status colors and hover effects

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check your `.env` file database credentials
   - Ensure MySQL service is running
   - Verify database exists

2. **Migration Errors**
   - Run `php artisan migrate:fresh` to reset database
   - Check for syntax errors in migration files

3. **Permission Issues**
   - Ensure storage and bootstrap/cache directories are writable
   - Run `chmod -R 775 storage bootstrap/cache`

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contributing

Feel free to submit issues and enhancement requests!
