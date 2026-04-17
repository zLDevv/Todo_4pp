<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/theme.js') }}"></script>

@if(session('success'))
    <div id="toast">✅ {{ session('success') }}</div>
    <script>
        setTimeout(() => document.getElementById('toast')?.remove(), 3000);
    </script>
@endif

<div class="container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1>My Tasks</h1>
            <p>Manage and track your personal tasks</p>
        </div>
        <div class="header-actions">
            <span class="user-badge">👤 {{ Auth::user()->name }}</span>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="nav-bar">
        <a href="/dashboard" class="btn nav-btn">Dashboard</a>
        <a href="/tasks" class="btn nav-btn">My Tasks</a>
        <a href="/team-tasks" class="btn nav-btn">Team Tasks</a>
        <a href="/teams" class="btn nav-btn">Teams</a>
        <a href="/inbox" class="btn nav-btn">Inbox</a>
        <a href="/calculator" class="btn nav-btn">Calc</a>
        <a href="/kanban" class="btn nav-btn">Kanban</a>
        <a href="/calendar" class="btn nav-btn">Calendar</a>
    </div>

    <!-- Search Section -->
    <form method="GET" class="search-container">
        <div class="search-input-wrapper">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search your tasks...">
        </div>
        <button type="submit" class="btn btn-add">🔍 Search</button>
    </form>

    <!-- Add Task Button -->
    <a href="/tasks/create" class="btn btn-add w-full" style="display: block; padding: 14px; margin-bottom: 28px;">+ Create New Task</a>

    <!-- Filter Buttons -->
    <div style="display: flex; gap: 10px; margin-bottom: 24px; flex-wrap: wrap; justify-content: center;">
        <a href="/tasks" class="filter-btn {{ !request('filter') && !request('search') ? 'active' : '' }}">All Tasks</a>
        <a href="/tasks?filter=pending" class="filter-btn {{ request('filter') == 'pending' ? 'active' : '' }}">⏳ Pending</a>
        <a href="/tasks?filter=done" class="filter-btn {{ request('filter') == 'done' ? 'active' : '' }}">✅ Done</a>
    </div>

    @if ($tasks->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">😴</div>
            <div class="empty-state-title">No tasks found</div>
            <div class="empty-state-text">You're all caught up! Create a new task to get started.</div>
        </div>
    @else
        @foreach ($tasks as $task)
            <div class="card task-card">
                <!-- Task Header -->
                <div class="task-header">
                    <div style="flex: 1;">
                        <div class="task-title {{ $task->status == 'done' ? 'done' : '' }}">{{ $task->title }}</div>
                        <div class="task-badges">
                            @if($task->category)
                                <span class="task-badge task-badge-category">📂 {{ $task->category }}</span>
                            @endif
                            <span class="task-badge task-badge-priority-{{ $task->priority }}">
                                @if($task->priority == 'low') 🟢 Low
                                @elseif($task->priority == 'medium') 🟡 Medium
                                @else 🔴 High @endif
                            </span>
                        </div>
                    </div>
                    <span class="task-status task-status-{{ $task->status }}">
                        {{ $task->status == 'done' ? '✅ Done' : '⏳ Pending' }}
                    </span>
                </div>

                <!-- Task Description -->
                @if($task->description)
                    <p class="task-description">{{ $task->description }}</p>
                @endif

                <!-- Task Metadata -->
                <div class="task-meta">
                    <div class="task-meta-item">
                        <span class="task-meta-label">📅 Deadline</span>
                        <span class="task-meta-value {{ strtotime($task->deadline) < time() && $task->status != 'done' ? 'overdue' : '' }}">
                            {{ date('M d, Y', strtotime($task->deadline)) }}
                        </span>
                    </div>
                    @if(strtotime($task->deadline) - time() < 432000 && $task->status != 'done')
                        <div class="task-meta-item" style="color: var(--danger);">
                            <span class="task-meta-label">⚠️ Deadline approaching</span>
                        </div>
                    @endif
                </div>

                <!-- Task Actions -->
                <div class="task-actions">
                    <form action="/tasks/{{ $task->id }}/favorite" method="POST" style="width: 100%;">
                        @csrf
                        <button class="btn w-full" style="background: {{ $task->favorite ? '#fbbf24' : 'rgba(107, 114, 128, 0.5)' }};">
                            {{ $task->favorite ? '⭐ Favorited' : '☆ Favorite' }}
                        </button>
                    </form>

                    @if ($task->status == 'pending')
                        <form action="/tasks/{{ $task->id }}/done" method="POST" style="width: 100%;">
                            @csrf
                            <button class="btn btn-done w-full">✓ Mark Done</button>
                        </form>
                    @else
                        <form action="/tasks/{{ $task->id }}/undone" method="POST" style="width: 100%;">
                            @csrf
                            <button class="btn w-full" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa);">↩️ Undo</button>
                        </form>
                    @endif

                    <div style="width: 100%;">
                        <a href="/tasks/{{ $task->id }}/edit" class="btn btn-edit w-full" style="background: linear-gradient(135deg, var(--warning), #fbbf24); text-decoration: none;">✏️ Edit</a>
                    </div>
                    <form action="/tasks/{{ $task->id }}" method="POST" style="width: 100%;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-delete w-full" onclick="openModal(this)">🗑️ Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">   
        <div class="modal-box">
            <h3>Delete Task</h3>
            <p>Are you sure? This action cannot be undone.</p>
            <div class="modal-actions">
                <button onclick="closeModal()" class="modal-btn btn-cancel">Cancel</button>
                <button id="confirmDelete" class="modal-btn btn-delete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteForm = null;

    function openModal(button) {
        deleteForm = button.closest('form');
        document.getElementById('deleteModal').classList.add('show');
    }

    function closeModal() {
        document.getElementById('deleteModal').classList.remove('show');
    }

    document.getElementById('confirmDelete').addEventListener('click', () => {
        if (deleteForm) deleteForm.submit();
    });

    document.getElementById('deleteModal')?.addEventListener('click', (e) => {
        if (e.target.id === 'deleteModal') closeModal();
    });
</script>

    <div id="deleteModal" class="modal">
        <div class="modal-box">
            <h3>Delete Task</h3>
            <p>Are you sure you want to delete this task?</p>

            <div class="modal-actions">
                <button onclick="closeModal()" class="btn-cancel">Cancel</button>
                <button id="confirmDelete" class="btn-delete">Delete</button>
            </div>
        </div>
    </div>
</div>

{{ $tasks->links() }}

<script>
    let deleteForm = null;

    function openModal(button) {
        deleteForm = button.closest('form');
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    document.getElementById('confirmDelete').addEventListener('click', function () {
        if (deleteForm) deleteForm.submit();
    });
</script>