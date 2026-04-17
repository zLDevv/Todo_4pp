<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<div class="container">
<!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1>Kanban Board</h1>
            <p>Manage your personal tasks and team tasks</p>
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

<!-- TEAM FILTER -->
<form method="GET" style="text-align:center; margin-bottom:20px;" >
    <select name="team_id" onchange="this.form.submit()">
        <option value="" style="background-color: #333">All Teams</option>
        @foreach($teams as $team)
            <option style="background-color: #333" value="{{ $team->id }}" {{ $teamId == $team->id ? 'selected' : '' }}>
                {{ $team->name }}
            </option>
        @endforeach
    </select>
</form>

<!-- KANBAN -->
<div class="kanban-container">

    @foreach (['pending','in_progress','done'] as $status)

        <div class="kanban-column" data-status="{{ $status }}">
            
            <div class="kanban-title">
                {{ strtoupper(str_replace('_',' ', $status)) }}
            </div>

            @foreach ($tasks[$status] ?? [] as $task)

                {{-- HANYA TASK PARENT --}}
                @if(!$task->parent_id)

                    <div class="kanban-task priority-{{ $task->priority }}" data-id="{{ $task->id }}">
                        
                        <div style="font-weight:600;">
                            {{ $task->title }}
                        </div>

                        {{-- SUBTASK --}}
                        @foreach($task->children as $child)
                            <div class="kanban-subtask">
                                ↳ {{ $child->title }}
                            </div>
                        @endforeach

                    </div>

                @endif

            @endforeach

        </div>

    @endforeach

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
    document.querySelectorAll('.kanban-column').forEach(column => {
        new Sortable(column, {
            group: 'tasks',
            animation: 150,
            onEnd: function (evt) {
                let taskId = evt.item.dataset.id;
                let newStatus = evt.to.dataset.status;
                
                fetch(`/tasks/${taskId}/move`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ status: newStatus })
                });
            }
        });
    });
    </script>