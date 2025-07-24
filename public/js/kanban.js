// Store all tasks data for modal access
let tasksData = [];

// Initialize the Kanban board
function initializeKanban(tasks) {
    tasksData = tasks;
    
    // Initialize Sortable for each column
    const columns = ['todo-column', 'in-progress-column', 'done-column'];
    
    columns.forEach(columnId => {
        const column = document.getElementById(columnId);
        if (column) {
            new Sortable(column, {
                group: 'tasks',
                animation: 150,
                ghostClass: 'kanban-task-ghost',
                chosenClass: 'kanban-task-chosen',
                dragClass: 'kanban-task-drag',
                onEnd: function(evt) {
                    const taskId = evt.item.dataset.taskId;
                    const newStatus = evt.to.dataset.status;
                    
                    // Update task status via AJAX
                    updateTaskStatus(taskId, newStatus);
                }
            });
        }
    });

    // Initialize modal forms
    initializeModalForms();
}

// Modal Functions
function openCreateModal() {
    const modal = new bootstrap.Modal(document.getElementById('createTaskModal'));
    modal.show();
}

function openViewModal(taskId) {
    const task = tasksData.find(t => t.id == taskId);
    if (!task) return;

    // Populate view modal
    document.getElementById('view_title').textContent = task.title;
    document.getElementById('view_description').textContent = task.description || 'No description provided';
    document.getElementById('view_created_at').textContent = new Date(task.created_at).toLocaleString();
    document.getElementById('view_updated_at').textContent = new Date(task.updated_at).toLocaleString();
    
    // Set status badge
    const statusBadge = document.getElementById('view_status_badge');
    statusBadge.textContent = task.status;
    statusBadge.className = 'badge status-badge ' + getStatusBadgeClass(task.status);
    
    // Set edit button to open edit modal for this task
    document.getElementById('editFromViewBtn').onclick = () => {
        bootstrap.Modal.getInstance(document.getElementById('viewTaskModal')).hide();
        openEditModal(taskId);
    };

    const modal = new bootstrap.Modal(document.getElementById('viewTaskModal'));
    modal.show();
}

function openEditModal(taskId) {
    const task = tasksData.find(t => t.id == taskId);
    if (!task) return;

    // Populate edit form
    document.getElementById('edit_task_id').value = task.id;
    document.getElementById('edit_title').value = task.title;
    document.getElementById('edit_description').value = task.description || '';
    document.getElementById('edit_status').value = task.status;

    const modal = new bootstrap.Modal(document.getElementById('editTaskModal'));
    modal.show();
}

function deleteTask(taskId) {
    console.log('Attempting to delete task:', taskId);
    
    if (confirm('Are you sure you want to delete this task?')) {
        const url = `/tasks/${taskId}`;
        console.log('DELETE request URL:', url);
        
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (!response.ok) {
                return response.text().then(text => {
                    console.log('Error response text:', text);
                    throw new Error(`HTTP error! status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Refresh the page to show updated task list
                window.location.reload();
            } else {
                alert('Failed to delete task: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting task: ' + error.message);
        });
    }
}

function getStatusBadgeClass(status) {
    switch(status) {
        case 'To Do': return 'bg-warning text-dark';
        case 'In Progress': return 'bg-info text-white';
        case 'Done': return 'bg-success text-white';
        default: return 'bg-secondary text-white';
    }
}

function initializeModalForms() {
    // Create task form
    document.getElementById('createTaskForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch('/tasks', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('createTaskModal')).hide();
                this.reset();
                // Refresh the page to show new task
                window.location.reload();
            } else {
                alert('Failed to create task: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error creating task: ' + error.message);
        });
    });

    // Edit task form
    document.getElementById('editTaskForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const taskId = document.getElementById('edit_task_id').value;
        const formData = new FormData(this);
        
        // Add the _method field for Laravel to recognize this as a PUT request
        formData.append('_method', 'PUT');
        
        console.log('Edit form - Task ID:', taskId);
        console.log('Edit form - FormData contents:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        fetch(`/tasks/${taskId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => {
            console.log('Edit response status:', response.status);
            if (!response.ok) {
                return response.text().then(text => {
                    console.log('Edit error response text:', text);
                    throw new Error(`HTTP error! status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                bootstrap.Modal.getInstance(document.getElementById('editTaskModal')).hide();
                // Refresh the page to show updated task
                window.location.reload();
            } else {
                alert('Failed to update task: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating task: ' + error.message);
        });
    });
}

function updateTaskStatus(taskId, newStatus) {
    fetch(`/tasks/${taskId}/update-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update task count badges
            updateTaskCounts();
        } else {
            console.error('Failed to update task status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function updateTaskCounts() {
    // This function would update the task count badges
    // For now, we'll just reload the page to show updated counts
    setTimeout(() => {
        window.location.reload();
    }, 500);
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // The tasks data will be passed from the view
    if (typeof window.tasksData !== 'undefined') {
        initializeKanban(window.tasksData);
    }
}); 