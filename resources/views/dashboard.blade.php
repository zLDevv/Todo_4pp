<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/theme.js') }}"></script>

<div class="container">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1>Dashboard</h1>
            <p>Your task overview and productivity insights</p>
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

    <!-- My Tasks Statistics -->
    <h2 class="section-title">My Tasks</h2>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Tasks</div>
            <div class="stat-value">{{ $my_total }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pending</div>
            <div class="stat-value">{{ $my_pending }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Completed</div>
            <div class="stat-value">{{ $my_done }}</div>
        </div>
    </div>

    <!-- Team Tasks Statistics -->
    <h2 class="section-title">Team Tasks</h2>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Tasks</div>
            <div class="stat-value">{{ $team_total }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pending</div>
            <div class="stat-value">{{ $team_pending }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Completed</div>
            <div class="stat-value">{{ $team_done }}</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card" style="margin-top: 40px;">
        <h2 class="section-title" style="margin-top: 0; border: none; padding: 0 0 20px 0;">Quick Actions</h2>
        <div class="quick-actions">
            <a href="/tasks" class="btn btn-add action-btn" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); text-decoration: none;">
                View All Tasks
            </a>
            <a href="/tasks/create" class="btn action-btn action-btn-create" style="text-decoration: none;">
                Create New Task
            </a>
            <a href="/teams" class="btn action-btn action-btn-browse" style="text-decoration: none;">
                Manage Teams
            </a>
        </div>
    </div>
</div>