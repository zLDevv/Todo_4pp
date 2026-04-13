<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/theme.js') }}"></script>

<div class="container">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1>Dashboard</h1>
            <p>Your task overview and statistics</p>
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

    <!-- Stats Cards Grid -->
    <section class="card section-card">
        <!-- My Tasks -->
        <h2 class="section-title"><span style="font-size: 1.4em;"></span> My Tasks</h2>
        <div class="stats-grid">
            <div class="card stat-card">
                <p>Total</p>
                <h2>{{ $my_total }}</h2>
            </div>
            <div class="card stat-card">
                <p>Pending</p>
                <h2>{{ $my_pending }}</h2>
            </div>
            <div class="card stat-card">
                <p>Done</p>
                <h2>{{ $my_done }}</h2>
            </div>
        </div>

        <!-- Team Tasks -->
        <h2 class="section-title" style="margin-top: 40px;"><span style="font-size: 1.4em;"></span> Team Tasks</h2>
        <div class="stats-grid">
            <div class="card stat-card">
                <p>Total</p>
                <h2>{{ $team_total }}</h2>
            </div>
            <div class="card stat-card">
                <p>Pending</p>
                <h2>{{ $team_pending }}</h2>
            </div>
            <div class="card stat-card">
                <p>Done</p>
                <h2>{{ $team_done }}</h2>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <div class="card quick-actions-card">
        <h2 class="section-title" style="margin-bottom: 20px;"><span style="font-size: 1.4em;"></span> Quick Actions</h2>
        <div class="quick-actions">
            <a href="/tasks" class="btn btn-add action-btn">📋 View All Tasks</a>
            <a href="/tasks/create" class="btn action-btn action-btn-create">✨ Create New Task</a>
            <a href="/teams" class="btn action-btn action-btn-browse">👥 Browse Teams</a>
        </div>
    </div>
</div>