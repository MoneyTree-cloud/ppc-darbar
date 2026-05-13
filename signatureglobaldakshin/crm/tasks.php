<?php
include('php/check_login.php');
include('php/config.php'); // Your DB connection

// Fetch admin names for the assignee dropdown
$admins = [];
$result = $conn->query("SELECT adminName FROM master_login ORDER BY adminName ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row['adminName'];
    }
}
$current_admin_name = $_SESSION['admin_name'] ?? 'Myself'; // Fetch current admin name from session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | To-Do List</title>
    <?php include('resource.php'); ?>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: rgba(0, 88, 79, 1);
            --accent-gold: #f8c200;
            --light-background: #f0f5f5;
            --form-background: #FFFFFF;
            --dark-text: #222222;
            --light-text: #555555;
            --border-color: #dee2e6;
            --completed-bg: #e8f5e9;
        }
        /* .main { padding: 20px; } */
        .todo-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .todo-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border-color);
            gap: 20px;
            flex-wrap: wrap;
        }
        .todo-header h1 {
            color: var(--primary-green);
            font-size: 2rem;
            margin: 0;
        }
        /* [NEW] Search Bar Styles */
        .search {
            position: relative;
            width: 350px;
            max-width: 100%;
        }
        .search label {
            position: relative;
            width: 100%;
        }
        .search input {
            width: 100%;
            height: 40px;
            border-radius: 8px;
            padding: 5px 20px 5px 40px;
            font-size: 1rem;
            outline: none;
            border: 1px solid var(--border-color);
            transition: border-color 0.3s, box-shadow 0.3s;
        }
         .search input:focus {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 4px rgba(248, 194, 0, 0.2);
         }
        .search ion-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: var(--light-text);
        }

        .btn-gold {
            background-color: var(--accent-gold);
            color: var(--dark-text);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .todo-section { margin-bottom: 40px; }
        .todo-section h2 {
            color: var(--dark-text);
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        .task-item {
            background: var(--form-background);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            align-items: flex-start;
            gap: 15px;
            border-left: 5px solid var(--accent-gold);
        }
        .task-item.completed {
            background-color: var(--completed-bg);
            border-left-color: var(--primary-green);
        }
        .task-item .checkbox {
            margin-top: 5px;
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary-green);
        }
        .task-content { flex-grow: 1; }
        .task-title {
            font-weight: 600;
            color: var(--dark-text);
            font-size: 1.1rem;
            margin: 0 0 5px;
        }
        .task-item.completed .task-title { text-decoration: line-through; color: var(--light-text); }
        .task-description {
            color: var(--light-text);
            margin: 0 0 10px;
            font-size: 0.95rem;
            white-space: pre-wrap;
        }
        .task-image {
            max-width: 150px;
            border-radius: 6px;
            margin-top: 10px;
            cursor: pointer;
        }
        .task-meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 15px;
            font-size: 0.85rem;
            color: #777;
            margin-top: 10px;
        }
        .task-meta span {
            background: #f1f3f5;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .task-actions { display: flex; gap: 10px; }
        .task-actions button { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--light-text); }
        .task-actions button:hover { color: var(--primary-green); }
        .task-actions .delete-btn:hover { color: #e03131; }

        /* Modal and Form Styles */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); display: none; justify-content: center; align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: var(--form-background); border-radius: 12px; padding: 30px;
            width: 90%; max-width: 600px; position: relative;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .modal-close {
            position: absolute; top: 15px; right: 15px; background: none; border: none;
            font-size: 1.8rem; cursor: pointer; color: var(--light-text);
        }
        .modal-content h2 { 
            color: var(--primary-green); 
            margin-top: 0;
            text-align: center;
            margin-bottom: 25px;
        }
        .modal-content .form-group { 
            position: relative; 
            margin-bottom: 25px;
            width: 100%; 
            max-width: 700px;
        }

        
        .form-group input:not([type="file"]), 
        .form-group textarea, 
        .form-group select {
            width: 100%; 
            padding: 14px; 
            border: 1px solid var(--border-color);
            border-radius: 8px; 
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            color: var(--dark-text);
            background-color: var(--form-background);
            transition: border-color 0.3s;
            position: relative;
            z-index: 1;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-group label {
            position: absolute;
            top: 15px;
            left: 15px;
            color: var(--light-text);
            background-color: var(--form-background);
            padding: 0 5px;
            transition: all 0.2s ease-in-out;
            pointer-events: none;
            font-size: 1rem;
            z-index: 2;
        }

        /* Floating label effect */
        .form-group input:not([type="file"]):focus + label,
        .form-group input:not([type="file"]):not(:placeholder-shown) + label,
        .form-group textarea:focus + label,
        .form-group textarea:not(:placeholder-shown) + label,
        .form-group select:focus + label,
        .form-group select:valid + label {
            top: -10px;
            left: 10px;
            padding: 5px;
            font-size: 0.8rem;
            color: var(--primary-green);
            background: white;
            font-weight: 600;
        }

        .form-group input:focus, 
        .form-group textarea:focus, 
        .form-group select:focus {
            outline: none;
            border-color: var(--accent-gold);
            color: black;
            box-shadow: 0 0 0 4px rgba(248, 194, 0, 0.2);
        }
        
        /* [MODIFIED] Custom File Input Styling */
        .form-group input[type="file"] {
            display: block;
        }
        /* .file-upload-label {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 80px;
            padding: 12px 20px;
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            background-color: #f8f9fa;
            color: var(--light-text);
            text-align: center;
            width: 100%;
            transition: background-color 0.3s, border-color 0.3s;
            font-weight: 600; 
        } 
        .file-upload-label:hover {
            background-color: #e9ecef;
            border-color: var(--accent-gold);
        } */
        /* .file-upload-label .upload-instruction {
            font-weight: 400;
            font-size: 0.9rem;
            color: var(--light-text);
        }
        .file-upload-label .file-name {
            display: block;
            margin-top: 8px;
            font-weight: 600;
            color: var(--primary-green);
            font-size: 0.9rem;
        } */

            .file-input {margin-bottom: 2rem; border: 2px dashed var(--accent-gold); border-radius: 8px; padding: 30px; margin-top: 20px; cursor: pointer; background-color: #FFFDF5; transition: background-color 0.3s; }
    .file-input:hover { background-color: #FEF9E7; }
    .file-input input[type="file"] { display: none; }
    .file-input label { color: var(--primary-green); font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <?php include('components/navbar.php') ?>
        <div class="main">
            <?php include('components/topbar.php'); ?>

            <div class="todo-container">
                <div class="todo-header">
                    <h1>My To-Do List</h1>
                    
                    <button class="btn-gold" id="addTaskBtn">Add New Task</button>
                </div>

                <div class="todo-section" id="pendingTasks">
                    <h2>Pending</h2>
                    <div id="pendingTasksList"></div>
                </div>

                <div class="todo-section" id="completedTasks">
                    <h2>Completed</h2>
                    <div id="completedTasksList"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Task Modal -->
    <div class="modal-overlay" id="taskModal">
        <div class="modal-content">
            <button class="modal-close" id="closeModalBtn">&times;</button>
            <h2 id="modalTitle">Add New Task</h2>
            <form id="taskForm" enctype="multipart/form-data">
                <input type="hidden" name="task_id" id="taskId">
                <div class="form-group">
                    <input type="text" id="taskTitle" name="title" required placeholder=" ">
                    <label for="taskTitle">Title <span style="color:red;">*</span></label>
                </div>
                <div class="form-group">
                    <textarea id="taskDescription" style="border: 1px solid var(--border-color);color: black;" name="description" rows="4" placeholder=" "></textarea>
                    <label for="taskDescription">Description</label>
                </div>
                
                <div class="file-input">
                    <input type="file" id="taskImage" name="image" accept="image/*">
                    <label for="taskImage" class="file-upload-label">
                        Image
                        <span class="upload-instruction">Click to upload an image</span>
                        <span class="file-name"></span>
                    </label>
                </div>
                
                <div class="form-group">
                    <input type="date" id="taskDueDate" name="due_date" required placeholder=" ">
                    <label for="taskDueDate">Due Date <span style="color:red;">*</span></label>
                </div>

                <div class="form-group">
                    <label for="taskAssignee" style="position: static; font-weight: 600; margin-bottom: 8px;">Assign To <span style="color:red;">*</span></label>
                    <select id="taskAssignee" name="assigned_to" required>
                        <option value="" disabled selected>Select an admin...</option>
                        <option value="<?= htmlspecialchars($current_admin_name) ?>">Myself (<?= htmlspecialchars($current_admin_name) ?>)</option>
                        <?php foreach ($admins as $admin) : ?>
                            <option value="<?= htmlspecialchars($admin) ?>"><?= htmlspecialchars($admin) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn-gold" style="width: 100%; padding: 14px;">Save Task</button>
            </form>
        </div>
    </div>
    
    <script src="main.js?v=<?= filemtime('main.js'); ?>"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Element References ---
        const addTaskBtn = document.getElementById('addTaskBtn');
        const taskModal = document.getElementById('taskModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const taskForm = document.getElementById('taskForm');
        const modalTitle = document.getElementById('modalTitle');
        const taskIdInput = document.getElementById('taskId');
        const taskImageInput = document.getElementById('taskImage');
        const fileNameSpan = document.querySelector('.file-name');
        const taskDueDateInput = document.getElementById('taskDueDate');
        const searchInput = document.getElementById('searchInput'); // [NEW]

        // --- Event Listeners ---
        addTaskBtn.addEventListener('click', openAddModal);
        closeModalBtn.addEventListener('click', closeModal);
        taskModal.addEventListener('click', (e) => { if (e.target === taskModal) closeModal(); });
        taskForm.addEventListener('submit', handleFormSubmit);
        taskImageInput.addEventListener('change', () => {
            fileNameSpan.textContent = taskImageInput.files.length > 0 ? `Selected: ${taskImageInput.files[0].name}` : '';
        });
        // [NEW] Add event listener for the search input
        searchInput.addEventListener('input', () => {
            fetchTasks(searchInput.value.trim());
        });

        // --- Functions ---
        function openAddModal() {
            taskForm.reset();
            fileNameSpan.textContent = '';
            taskIdInput.value = '';
            modalTitle.textContent = 'Add New Task';
            taskDueDateInput.value = new Date().toISOString().split('T')[0];
            taskModal.style.display = 'flex';
        }

        function openEditModal(task) {
            taskForm.reset();
            fileNameSpan.textContent = '';
            modalTitle.textContent = 'Edit Task';
            taskIdInput.value = task.id;
            document.getElementById('taskTitle').value = task.title;
            document.getElementById('taskDescription').value = task.description;
            document.getElementById('taskAssignee').value = task.assigned_to;
            taskDueDateInput.value = task.due_date;
            taskModal.style.display = 'flex';
        }

        function closeModal() {
            taskModal.style.display = 'none';
        }

        async function handleFormSubmit(e) {
            e.preventDefault();
            const formData = new FormData(taskForm);
            const action = taskIdInput.value ? 'update' : 'add';
            formData.append('action', action);

            try {
                const response = await fetch('php/todo_api.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) {
                    closeModal();
                    fetchTasks(searchInput.value.trim()); // Refresh list with current search
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Submit Error:', error);
                alert('An unexpected error occurred.');
            }
        }

        // [MODIFIED] Function now accepts a search term
        async function fetchTasks(searchTerm = '') {
            try {
                const response = await fetch(`php/todo_api.php?action=fetch&search=${encodeURIComponent(searchTerm)}`);
                const tasks = await response.json();
                renderTasks(tasks);
            } catch (error) {
                console.error('Fetch Error:', error);
            }
        }

        function renderTasks(tasks) {
            const pendingList = document.getElementById('pendingTasksList');
            const completedList = document.getElementById('completedTasksList');
            pendingList.innerHTML = '';
            completedList.innerHTML = '';

            const pendingTasks = tasks.filter(t => t.status === 'pending');
            const completedTasks = tasks.filter(t => t.status === 'completed');
            
            const noPendingMsg = searchInput.value.trim() ? 'No pending tasks match your search.' : 'No pending tasks. Well done!';
            const noCompletedMsg = searchInput.value.trim() ? 'No completed tasks match your search.' : 'No tasks completed yet.';

            if (pendingTasks.length === 0) {
                pendingList.innerHTML = `<p style="text-align:center; color: #777;">${noPendingMsg}</p>`;
            } else {
                pendingTasks.forEach(task => pendingList.appendChild(createTaskElement(task)));
            }
            
            if (completedTasks.length === 0) {
                 completedList.innerHTML = `<p style="text-align:center; color: #777;">${noCompletedMsg}</p>`;
            } else {
                 completedTasks.forEach(task => completedList.appendChild(createTaskElement(task)));
            }
            addEventListenersToTasks();
        }

        function createTaskElement(task) {
            const taskEl = document.createElement('div');
            taskEl.className = `task-item ${task.status}`;
            const formattedDueDate = task.due_date ? new Date(task.due_date).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' }) : '';
            const formattedAssignedDate = task.created_at ? new Date(task.created_at).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' }) : '';

            taskEl.innerHTML = `
                <input type="checkbox" class="checkbox" data-id="${task.id}" ${task.status === 'completed' ? 'checked' : ''}>
                <div class="task-content">
                    <h3 class="task-title">${task.title}</h3>
                    ${task.description ? `<p class="task-description">${task.description}</p>` : ''}
                    ${task.image_path ? `<img src="uploads/todos/${task.image_path}" alt="Task Image" class="task-image">` : ''}
                    <div class="task-meta">
                        <span>Assigned to: <strong>${task.assigned_to}</strong></span>
                        ${formattedAssignedDate ? `<span>Assigned: <strong>${formattedAssignedDate}</strong></span>` : ''}
                        ${formattedDueDate ? `<span>Due: <strong>${formattedDueDate}</strong></span>` : ''}
                    </div>
                </div>
                <div class="task-actions">
                    <button class="edit-btn" data-id="${task.id}" title="Edit Task"><ion-icon name="create-outline"></ion-icon></button>
                    <button class="delete-btn" data-id="${task.id}" title="Delete Task"><ion-icon name="trash-outline"></ion-icon></button>
                </div>
            `;
            return taskEl;
        }
        
        function addEventListenersToTasks() {
            document.querySelectorAll('.checkbox').forEach(cb => {
                cb.addEventListener('change', (e) => toggleTaskStatus(e.target.dataset.id));
            });
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    const id = e.currentTarget.dataset.id;
                    const response = await fetch(`php/todo_api.php?action=get&id=${id}`);
                    const task = await response.json();
                    openEditModal(task);
                });
            });
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', (e) => deleteTask(e.currentTarget.dataset.id));
            });
        }

        async function toggleTaskStatus(id) {
            const formData = new FormData();
            formData.append('action', 'toggle_status');
            formData.append('task_id', id);
            await fetch('php/todo_api.php', { method: 'POST', body: formData });
            fetchTasks(searchInput.value.trim()); // Refresh with search
        }

        async function deleteTask(id) {
            if (!confirm('Are you sure you want to delete this task?')) return;
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('task_id', id);
            await fetch('php/todo_api.php', { method: 'POST', body: formData });
            fetchTasks(searchInput.value.trim()); // Refresh with search
        }

        // Initial Fetch
        fetchTasks();
    });
    </script>
</body>
</html>

