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
            <h1>Teams</h1>
            <p>Manage and collaborate with your teams effortlessly</p>
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

    <!-- Create Team Button -->
    <a href="/teams/create" class="btn btn-add w-full" style="display: block; padding: 14px; margin-bottom: 28px; text-decoration: none;">+ Create New Team</a>

    <!-- Teams You Own Section -->
    @if ($ownedTeams->count() > 0)
        <div class="mb-35">
            <h2 class="section-title">Teams You Own</h2>
            <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 20px;">Managing {{ $ownedTeams->count() }} team(s)</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                @foreach ($ownedTeams as $team)
                    <div class="card" style="display: flex; flex-direction: column;">
                        <!-- Team Header -->
                        <div style="margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                            <h3 style="margin: 0 0 8px 0; font-size: 1.3em; color: var(--info);">{{ $team->name }}</h3>
                            <span style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.1)); color: var(--success); padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; display: inline-block;">👑 Owner</span>
                        </div>

                        <!-- Team Description -->
                        @if ($team->description)
                            <p style="color: var(--text-muted); font-size: 13px; line-height: 1.6; margin: 0 0 16px 0;">{{ $team->description }}</p>
                        @else
                            <p style="color: var(--text-muted); font-size: 13px; margin: 0 0 16px 0; font-style: italic;">No description provided</p>
                        @endif
                        
                        <!-- Member Count -->
                        <div style="background: rgba(255, 255, 255, 0.05); padding: 14px; border-radius: 8px; text-align: center; margin-bottom: 16px; border: 1px solid rgba(255, 255, 255, 0.1);">
                            <p style="color: var(--text-muted); font-size: 12px; margin: 0 0 6px 0; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Team Members</p>
                            <p style="color: var(--info); font-size: 2em; font-weight: 800; margin: 0;">{{ $team->members()->count() }}</p>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; margin-top: auto;">
                            <a href="/teams/{{ $team->id }}" class="btn btn-done" style="padding: 10px; text-decoration: none; text-align: center; font-size: 13px;">View</a>
                            <a href="/teams/{{ $team->id }}/edit" class="btn" style="background: linear-gradient(135deg, var(--warning), #fbbf24); padding: 10px; text-decoration: none; text-align: center; font-size: 13px;">Edit</a>
                            <form action="/teams/{{ $team->id }}" method="POST" style="display: block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-delete" onclick="openModal(this)" style="width: 100%; padding: 10px; font-size: 13px;">🗑️ Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Teams You Joined Section -->
    @if ($memberTeams->count() > 0)
        <div class="mb-35">
            <h2 class="section-title">Teams You Joined</h2>
            <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 20px;">Member in {{ $memberTeams->count() }} team(s)</p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                @foreach ($memberTeams as $team)
                    <div class="card" style="display: flex; flex-direction: column;">
                        <!-- Team Header -->
                        <div style="margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                            <h3 style="margin: 0 0 8px 0; font-size: 1.3em; color: var(--info);">{{ $team->name }}</h3>
                            <div style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                                <span style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(139, 92, 246, 0.1)); color: #a78bfa; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase;">Member</span>
                                <span style="color: var(--text-muted); font-size: 12px;">by {{ $team->owner->name }}</span>
                            </div>
                        </div>

                        <!-- Team Description -->
                        @if ($team->description)
                            <p style="color: var(--text-muted); font-size: 13px; line-height: 1.6; margin: 0 0 16px 0;">{{ $team->description }}</p>
                        @else
                            <p style="color: var(--text-muted); font-size: 13px; margin: 0 0 16px 0; font-style: italic;">No description provided</p>
                        @endif
                        
                        <!-- Member Count -->
                        <div style="background: rgba(255, 255, 255, 0.05); padding: 14px; border-radius: 8px; text-align: center; margin-bottom: 16px; border: 1px solid rgba(255, 255, 255, 0.1);">
                            <p style="color: var(--text-muted); font-size: 12px; margin: 0 0 6px 0; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Total Members</p>
                            <p style="color: #a78bfa; font-size: 2em; font-weight: 800; margin: 0;">{{ $team->members()->count() }}</p>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: auto;">
                            <a href="/team-tasks" class="btn btn-done" style="padding: 10px; text-decoration: none; text-align: center; font-size: 13px;">📋 View Tasks</a>
                            <a href="/teams/{{ $team->id }}" class="btn" style="background: linear-gradient(135deg, #8b5cf6, #a78bfa); padding: 10px; text-decoration: none; text-align: center; font-size: 13px;">👥 Details</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if ($ownedTeams->count() === 0 && $memberTeams->count() === 0)
        <div class="empty-state">
            <div class="empty-state-icon">👥</div>
            <div class="empty-state-title">No Teams Yet</div>
            <div class="empty-state-text">Start collaborating by creating or joining a team.</div>
            <a href="/teams/create" class="empty-state-action">Create Your First Team →</a>
        </div>
    @endif

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">   
        <div class="modal-box">
            <h3>Delete Team</h3>
            <p>Are you sure? This action cannot be undone. All team data will be lost.</p>
            <div class="modal-actions">
                <button onclick="closeModal()" class="modal-btn btn-cancel">Cancel</button>
                <button id="confirmDelete" class="modal-btn btn-delete">Delete Team</button>
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
