# Task Manager

A modern Laravel-based Task Manager application featuring a Jira-style Kanban board with drag-and-drop functionality, Bootstrap modals, and MySQL database.

## Features

- ✅ **Jira-style Kanban Board** with three columns (To Do, In Progress, Done)
- ✅ **Drag and Drop** functionality using SortableJS
- ✅ **Modal-based Operations** - Create, edit, and view tasks in popup modals
- ✅ **Real-time Status Updates** via AJAX without page reloads
- ✅ **Responsive Bootstrap 5 Design** with modern UI
- ✅ **Task Management** - Create, edit, delete, and view tasks
- ✅ **Status Management** - Mark tasks as "To Do," "In Progress," or "Done"
- ✅ **No Authentication Required** - Simple and straightforward
- ✅ **Modern UI** with hover effects, icons, and smooth animations

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL/MariaDB
- Laravel 10.x
- Modern web browser (for drag and drop functionality)

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

### Kanban Board Interface
- **Three Columns**: To Do, In Progress, Done
- **Task Cards**: Each task is displayed as a card with title, description preview, and action buttons
- **Drag and Drop**: Click and drag tasks between columns to change their status
- **Task Counts**: Each column header shows the number of tasks in that status

### Creating Tasks
1. Click the "New Task" button in the navigation bar
2. Fill in the task title (required)
3. Add an optional description
4. Select the initial status
5. Click "Create Task"
6. The task will appear in the appropriate column

### Editing Tasks
1. Click the edit icon (pencil) on any task card
2. Modify the title, description, or status
3. Click "Update Task"
4. The task will be updated and may move to a different column if status changed

### Viewing Task Details
1. Click the view icon (eye) on any task card
2. See complete task information including:
   - Full title and description
   - Current status with color-coded badge
   - Creation and last update timestamps
3. Click "Edit Task" to modify from the detail view

### Deleting Tasks
1. Click the delete icon (trash) on any task card
2. Confirm the deletion in the popup dialog
3. The task will be removed from the board

### Drag and Drop
- **Move Tasks**: Click and drag any task card to a different column
- **Status Update**: The task status automatically updates when dropped in a new column
- **Visual Feedback**: Cards show visual feedback during dragging
- **Real-time Updates**: Changes are saved immediately via AJAX

## Project Structure

```
task-manager/
├── app/
│   ├── Http/Controllers/
│   │   └── TaskController.php      # Handles all task operations with AJAX support
│   └── Models/
│       └── Task.php               # Task model with status constants
├── database/
│   ├── migrations/
│   │   └── create_tasks_table.php # Database schema
│   └── seeders/
│       └── TaskSeeder.php         # Sample data
├── public/
│   ├── css/
│   │   └── kanban.css            # Custom Kanban board styles
│   └── js/
│       └── kanban.js             # JavaScript for modals and drag/drop
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php      # Main layout with modals and Bootstrap
│       └── tasks/
│           └── index.blade.php    # Kanban board view
└── routes/
    └── web.php                    # Application routes
```

## Database Schema

The `tasks` table contains:
- `id` - Primary key
- `title` - Task title (required, max 255 characters)
- `description` - Task description (optional, text)
- `status` - Task status (enum: 'To Do', 'In Progress', 'Done')
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

## Technical Features

### Frontend Technologies
- **Bootstrap 5** - Responsive UI framework
- **Bootstrap Icons** - Modern icon set
- **SortableJS** - Drag and drop functionality
- **Fetch API** - AJAX requests for seamless interactions

### Backend Features
- **Laravel 10** - PHP framework
- **Eloquent ORM** - Database operations
- **Route Model Binding** - Automatic model resolution
- **AJAX Support** - JSON responses for all operations
- **CSRF Protection** - Security for all requests

### Key JavaScript Functions
- `initializeKanban()` - Sets up drag and drop functionality
- `openCreateModal()` - Opens task creation modal
- `openEditModal()` - Opens task editing modal
- `openViewModal()` - Opens task detail modal
- `deleteTask()` - Handles task deletion
- `updateTaskStatus()` - Updates status via drag and drop

## Customization

### Adding New Status Types
1. Update the migration file to include new enum values
2. Add constants to the Task model
3. Update the modal select options in `app.blade.php`
4. Add corresponding CSS classes in `kanban.css`
5. Run `php artisan migrate:fresh --seed`

### Styling Changes
- Modify `public/css/kanban.css` for Kanban board styles
- Update `public/js/kanban.js` for JavaScript functionality
- Customize Bootstrap classes in the view files

### Adding New Features
- **Due Dates**: Add a `due_date` column to the tasks table
- **Priority Levels**: Add a `priority` enum field
- **Task Categories**: Add a `category_id` foreign key
- **User Assignment**: Add user relationships for multi-user support

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check your `.env` file database credentials
   - Ensure MySQL service is running
   - Verify database exists

2. **Migration Errors**
   - Run `php artisan migrate:fresh` to reset database
   - Check for syntax errors in migration files

3. **JavaScript Errors**
   - Check browser console for errors
   - Ensure SortableJS is loaded properly
   - Verify CSRF token is present

4. **Drag and Drop Not Working**
   - Check if SortableJS library is loaded
   - Verify column IDs match in HTML and JavaScript
   - Check browser console for JavaScript errors

5. **Modal Issues**
   - Ensure Bootstrap JS is loaded
   - Check for JavaScript errors in console
   - Verify modal IDs match in HTML and JavaScript

6. **AJAX Request Failures**
   - Check network tab in browser dev tools
   - Verify CSRF token is being sent
   - Check Laravel logs for server-side errors

### Performance Optimization
- **Route Caching**: Run `php artisan route:cache` in production
- **Config Caching**: Run `php artisan config:cache` in production
- **View Caching**: Run `php artisan view:cache` in production

## Browser Compatibility

- **Chrome** 60+ ✅
- **Firefox** 55+ ✅
- **Safari** 12+ ✅
- **Edge** 79+ ✅

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contributing

Feel free to submit issues and enhancement requests!
