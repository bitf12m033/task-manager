<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Task Manager')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom Kanban CSS -->
    <link href="{{ asset('css/kanban.css') }}" rel="stylesheet">
    <!-- SortableJS for drag and drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('tasks.index') }}">
                <i class="bi bi-kanban me-2"></i>Task Manager
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('tasks.index') }}">
                    <i class="bi bi-kanban me-1"></i>Kanban Board
                </a>
                <button class="nav-link btn btn-link" onclick="openCreateModal()">
                    <i class="bi bi-plus-circle me-1"></i>New Task
                </button>
            </div>
        </div>
    </nav>

    <main class="container-fluid p-0">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">
                        <i class="bi bi-plus-circle me-2"></i>Create New Task
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="createTaskForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="create_title" class="form-label">Task Title *</label>
                            <input type="text" class="form-control" id="create_title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="create_description" class="form-label">Description</label>
                            <textarea class="form-control" id="create_description" name="description" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="create_status" class="form-label">Status *</label>
                            <select class="form-select" id="create_status" name="status" required>
                                <option value="">Select status</option>
                                <option value="To Do">To Do</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Create Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>Edit Task
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editTaskForm">
                    <div class="modal-body">
                        <input type="hidden" id="edit_task_id" name="task_id">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Task Title *</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Status *</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="">Select status</option>
                                <option value="To Do">To Do</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle me-1"></i>Update Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Task Modal -->
    <div class="modal fade" id="viewTaskModal" tabindex="-1" aria-labelledby="viewTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewTaskModalLabel">
                        <i class="bi bi-eye me-2"></i>Task Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="task-detail-item">
                        <div class="task-detail-label">Title</div>
                        <div class="task-detail-value" id="view_title"></div>
                    </div>
                    <div class="task-detail-item">
                        <div class="task-detail-label">Description</div>
                        <div class="task-detail-value" id="view_description"></div>
                    </div>
                    <div class="task-detail-item">
                        <div class="task-detail-label">Status</div>
                        <div class="task-detail-value">
                            <span id="view_status_badge" class="badge status-badge"></span>
                        </div>
                    </div>
                    <div class="task-detail-item">
                        <div class="task-detail-label">Created</div>
                        <div class="task-detail-value" id="view_created_at"></div>
                    </div>
                    <div class="task-detail-item">
                        <div class="task-detail-label">Last Updated</div>
                        <div class="task-detail-value" id="view_updated_at"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning" id="editFromViewBtn">
                        <i class="bi bi-pencil me-1"></i>Edit Task
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Kanban JavaScript -->
    <script src="{{ asset('js/kanban.js') }}"></script>
</body>
</html> 