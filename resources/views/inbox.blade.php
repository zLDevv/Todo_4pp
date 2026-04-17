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
            <h1>Inbox</h1>
            <p>Manage your team invitations and stay connected</p>
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

    @if ($invitations->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">📬</div>
            <div class="empty-state-title">No Pending Invitations</div>
            <div class="empty-state-text">You're all caught up! Visit your teams to manage existing collaborations.</div>
            <a href="/teams" class="empty-state-action">Browse Teams →</a>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            @foreach ($invitations as $invitation)
                <div class="card">
                    <!-- Team Name -->
                    <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                        <h3 style="margin: 0 0 8px 0; font-size: 1.3em; color: var(--info);">🤝 {{ $invitation->team->name }}</h3>
                        @if ($invitation->team->description)
                            <p style="margin: 8px 0 0 0; color: var(--text-muted); font-size: 13px; line-height: 1.5;">{{ Str::limit($invitation->team->description, 80) }}</p>
                        @endif
                    </div>

                    <!-- Invited By -->
                    <div style="background: rgba(255, 255, 255, 0.05); padding: 14px; border-radius: 8px; margin-bottom: 16px; border: 1px solid rgba(255, 255, 255, 0.1);">
                        <p style="color: var(--text-muted); font-size: 12px; margin: 0 0 6px 0; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">👤 Invited by</p>
                        <p style="color: white; font-size: 14px; font-weight: 600; margin: 0;">{{ $invitation->team->owner->name ?? 'Unknown' }}</p>
                    </div>

                    <!-- Invitation Message -->
                    <p style="color: var(--text-muted); font-size: 13px; line-height: 1.6; margin: 0 0 16px 0;">You've been invited to join the <strong>{{ $invitation->team->name }}</strong> team. Accept to start collaborating!</p>

                    <!-- Action Buttons -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                        <a href="/team-invitations/{{ $invitation->token }}/accept" class="btn btn-done" style="padding: 11px 16px; text-decoration: none; text-align: center; font-size: 13px; font-weight: 600;">✅ Accept</a>
                        <a href="/team-invitations/{{ $invitation->token }}/decline" class="btn btn-delete" style="padding: 11px 16px; text-decoration: none; text-align: center; font-size: 13px; font-weight: 600;">❌ Decline</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
