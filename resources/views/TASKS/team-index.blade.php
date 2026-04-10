<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/theme.js') }}"></script>

@if(session('success'))
    <div id="toast" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 14px 16px; margin-bottom: 20px; border-radius: 8px; font-weight: 500; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); animation: slideIn 0.3s ease;">
        ✅ {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('toast').style.display = 'none';
        }, 3000);
    </script>
@endif

<div class="container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1>Team Tasks</h1>
            <p>Collaborate with your teams</p>
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
        <a href="/inbox" class="btn btn-add nav-btn">Inbox</a>
        <a href="/calculator" class="btn nav-btn">Calc</a>
    </div>

    <!-- Add Task Button -->
    <a href="/create-team-task" class="btn btn-add" style="text-decoration: none; padding: 12px 20px; display: inline-block; margin-bottom: 25px; font-weight: 600; border: none; cursor: pointer;">+ Add Team Task</a>

    <!-- Search Section -->
    <form method="GET" style="margin-bottom: 25px; display: flex; gap: 10px; align-items: center;">
        <div style="flex: 1; display: flex; align-items: center; background: white; border-radius: 8px; border: 2px solid #e0e0e0; transition: all 0.3s ease;">
            <svg style="width: 18px; height: 18px; margin: 0 12px; color: #9ca3af; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search team tasks..." style="flex: 1; border: none; padding: 12px 0; padding-right: 12px; font-size: 14px;">
        </div>
        <button type="submit" class="btn btn-add" style="padding: 10px 18px; font-size: 13px; border: none; cursor: pointer;">🔍 Search</button>
    </form>

    @if ($tasks->isEmpty())
        <div style="background: rgba(255, 255, 255, 0.08); border: 2px dashed rgba(255, 255, 255, 0.2); border-radius: 12px; padding: 60px 20px; text-align: center;">
            <p style="color: rgba(255, 255, 255, 0.6); font-size: 24px; margin: 0 0 12px 0;">🤝</p>
            <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 16px;">No team tasks yet</p>
            <p style="color: rgba(255, 255, 255, 0.5); margin: 8px 0 0 0; font-size: 13px;"><a href="/teams" style="color: #17a2b8; text-decoration: none; font-weight: 600;">Create a team first</a></p>
        </div>
    @else
        @foreach ($tasks as $teamId => $teamTasks)
            @php
                $team = $teamTasks->first()->team;
            @endphp
            
            <div style="margin-bottom: 35px;">
                <!-- Team Header -->
                <div style="background: linear-gradient(135deg, rgba(23, 162, 184, 0.95) 0%, rgba(15, 125, 143, 0.95) 100%); padding: 25px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);">
                    <h2 style="margin: 0 0 8px 0; color: white; font-size: 24px; font-weight: 700;">{{ $team->name ?? 'Unknown Team' }}</h2>
                    @if ($team && $team->description)
                        <p style="margin: 0; color: rgba(255, 255, 255, 0.9); font-size: 14px;">{{ $team->description }}</p>
                    @endif
                </div>

                <!-- Team Tasks -->
                @foreach ($teamTasks as $task)
                    <div class="card" style="margin-bottom: 16px;">
                        <!-- Task Header -->
                        <div style="display: flex; align-items: start; justify-content: space-between; margin-bottom: 12px;">
                            <div style="flex: 1;">
                                <h3 class="{{ $task->status == 'done' ? 'done' : '' }}" style="margin: 0 0 4px 0; font-size: 18px;">
                                    {{ $task->title }}
                                </h3>
                                <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                                    @if($task->category)
                                        <span style="background: rgba(23, 162, 184, 0.2); color: #17a2b8; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">📂 {{ $task->category }}</span>
                                    @endif
                                    <span class="priority-{{ $task->priority }}" style="padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                                        @if($task->priority == 'low')
                                            🟢 Low
                                        @elseif($task->priority == 'medium')
                                            🟡 Medium
                                        @else
                                            🔴 High
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div style="margin-left: 12px;">
                                <span style="background: {{ $task->status == 'done' ? '#10b981' : '#f59e0b' }}; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                    {{ $task->status == 'done' ? '✅ Done' : '⏳ Pending' }}
                                </span>
                            </div>
                        </div>

                        <!-- Task Description -->
                        @if($task->description)
                            <p style="color: #e0e0e0; margin: 10px 0; font-size: 14px; line-height: 1.5;">{{ $task->description }}</p>
                        @endif

                        <!-- Task Info -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin: 12px 0; padding: 12px 0; border-top: 1px solid rgba(255, 255, 255, 0.1); border-bottom: 1px solid rgba(255, 255, 255, 0.1); font-size: 13px;">
                            <div>
                                <span style="color: rgba(255, 255, 255, 0.6);">👤 Assigned by:</span>
                                <p style="margin: 4px 0 0 0; color: white; font-weight: 500;">{{ $task->user->name ?? 'Unknown' }}</p>
                            </div>
                            <div>
                                <span style="color: rgba(255, 255, 255, 0.6);">📅 Deadline:</span>
                                <p style="margin: 4px 0 0 0; color: {{ strtotime($task->deadline) < time() ? '#ef4444' : 'white' }}; font-weight: 500;">{{ date('M d, Y', strtotime($task->deadline)) }}</p>
                            </div>
                        </div>

                        <!-- Task Actions -->
                        <div style="display: flex; gap: 8px; flex-wrap: wrap; justify-content: space-between;">
                            <div>
                                @if ($task->status == 'pending')
                                    <form action="/tasks/{{ $task->id }}/done" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn btn-done" style="padding: 8px 12px; font-size: 12px; border: none; cursor: pointer;">✓ Mark Done</button>
                                    </form>
                                @else
                                    <form action="/tasks/{{ $task->id }}/undone" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="btn" style="background: #8b5cf6; padding: 8px 12px; font-size: 12px; border: none; cursor: pointer;">↩️ Undone</button>
                                    </form>
                                @endif
                            </div>

                            @if ($task->user_id == Auth::id())
                                <div style="display: flex; gap: 8px;">
                                    <a href="/tasks/{{ $task->id }}/edit" class="btn" style="background: #f59e0b; padding: 8px 12px; font-size: 12px; text-decoration: none; border: none; cursor: pointer;">✏️ Edit</a>

                                    <form action="/tasks/{{ $task->id }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-delete" onclick="openModal(this)">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif

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
