@extends('layouts.app')

@section('title', 'Kanban Board - Task Manager')

@section('content')
<div class="kanban-board">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-white">
                <i class="bi bi-kanban me-2"></i>Kanban Board
            </h1>
            <button class="btn btn-light" onclick="openCreateModal()">
                <i class="bi bi-plus-circle me-1"></i>New Task
            </button>
        </div>

        <div class="row">
            <!-- To Do Column -->
            <div class="col-md-4">
                <div class="kanban-column todo">
                    <div class="kanban-column-header">
                        <i class="bi bi-clock me-2"></i>To Do
                        <span class="task-count">{{ $tasks->where('status', 'To Do')->count() }}</span>
                    </div>
                    <div class="kanban-tasks" id="todo-column" data-status="To Do">
                        @forelse($tasks->where('status', 'To Do') as $task)
                            <div class="kanban-task todo" data-task-id="{{ $task->id }}">
                                <div class="task-title">{{ $task->title }}</div>
                                @if($task->description)
                                    <div class="task-description">{{ Str::limit($task->description, 80) }}</div>
                                @endif
                                <div class="task-meta">
                                    <span><i class="bi bi-calendar3 me-1"></i>{{ $task->created_at->format('M d') }}</span>
                                </div>
                                <div class="task-actions">
                                    <button class="btn btn-outline-primary btn-sm" onclick="openViewModal({{ $task->id }})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="openEditModal({{ $task->id }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="deleteTask({{ $task->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="empty-column">
                                <i class="bi bi-inbox display-6"></i>
                                <p class="mt-2">No tasks here</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- In Progress Column -->
            <div class="col-md-4">
                <div class="kanban-column in-progress">
                    <div class="kanban-column-header">
                        <i class="bi bi-arrow-clockwise me-2"></i>In Progress
                        <span class="task-count">{{ $tasks->where('status', 'In Progress')->count() }}</span>
                    </div>
                    <div class="kanban-tasks" id="in-progress-column" data-status="In Progress">
                        @forelse($tasks->where('status', 'In Progress') as $task)
                            <div class="kanban-task in-progress" data-task-id="{{ $task->id }}">
                                <div class="task-title">{{ $task->title }}</div>
                                @if($task->description)
                                    <div class="task-description">{{ Str::limit($task->description, 80) }}</div>
                                @endif
                                <div class="task-meta">
                                    <span><i class="bi bi-calendar3 me-1"></i>{{ $task->created_at->format('M d') }}</span>
                                </div>
                                <div class="task-actions">
                                    <button class="btn btn-outline-primary btn-sm" onclick="openViewModal({{ $task->id }})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="openEditModal({{ $task->id }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="deleteTask({{ $task->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="empty-column">
                                <i class="bi bi-arrow-clockwise display-6"></i>
                                <p class="mt-2">No tasks in progress</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Done Column -->
            <div class="col-md-4">
                <div class="kanban-column done">
                    <div class="kanban-column-header">
                        <i class="bi bi-check-circle me-2"></i>Done
                        <span class="task-count">{{ $tasks->where('status', 'Done')->count() }}</span>
                    </div>
                    <div class="kanban-tasks" id="done-column" data-status="Done">
                        @forelse($tasks->where('status', 'Done') as $task)
                            <div class="kanban-task done" data-task-id="{{ $task->id }}">
                                <div class="task-title">{{ $task->title }}</div>
                                @if($task->description)
                                    <div class="task-description">{{ Str::limit($task->description, 80) }}</div>
                                @endif
                                <div class="task-meta">
                                    <span><i class="bi bi-calendar3 me-1"></i>{{ $task->created_at->format('M d') }}</span>
                                </div>
                                <div class="task-actions">
                                    <button class="btn btn-outline-primary btn-sm" onclick="openViewModal({{ $task->id }})">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="openEditModal({{ $task->id }})">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" onclick="deleteTask({{ $task->id }})">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="empty-column">
                                <i class="bi bi-check-circle display-6"></i>
                                <p class="mt-2">No completed tasks</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Pass tasks data to external JavaScript file
    window.tasksData = @json($tasks);
</script>
@endsection 