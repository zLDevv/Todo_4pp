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
            <h1>Inbox</h1>
            <p>Manage your team invitations</p>
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

    @if ($invitations->isEmpty())
        <div style="background: rgba(255, 255, 255, 0.08); border: 2px dashed rgba(255, 255, 255, 0.2); border-radius: 12px; padding: 60px 20px; text-align: center;">
            <p style="color: rgba(255, 255, 255, 0.6); font-size: 24px; margin: 0 0 12px 0;">📬</p>
            <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 16px;">No pending invitations</p>
            <p style="color: rgba(255, 255, 255, 0.5); margin: 8px 0; font-size: 13px;">You're all caught up!</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">
            @foreach ($invitations as $invitation)
                <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; border-left: 4px solid #17a2b8; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);">
                    <!-- Card Header -->
                    <div style="background: linear-gradient(135deg, rgba(23, 162, 184, 0.1) 0%, rgba(15, 125, 143, 0.1) 100%); padding: 20px;">
                        <h3 style="margin: 0 0 8px 0; color: #17a2b8; font-size: 18px; font-weight: 700;">🤝 {{ $invitation->team->name }}</h3>
                        @if ($invitation->team->description)
                            <p style="font-size: 13px; color: #666; margin: 8px 0 0 0;">{{ $invitation->team->description }}</p>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div style="padding: 20px;">
                        <div style="background: #f3f4f6; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                            <p style="color: #666; font-size: 12px; margin: 0 0 6px 0; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">👤 Invited by</p>
                            <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0;">{{ $invitation->team->owner->name ?? 'Unknown' }}</p>
                        </div>

                        <p style="color: #666; font-size: 13px; line-height: 1.6;">You've been invited to join the <strong>{{ $invitation->team->name }}</strong> team. Accept to start collaborating or decline to skip.</p>
                    </div>

                    <!-- Card Actions -->
                    <div style="padding: 0 20px 20px 20px; display: flex; gap: 10px;">
                        <a href="/team-invitations/{{ $invitation->token }}/accept" class="btn btn-done" style="flex: 1; padding: 12px; text-decoration: none; text-align: center; font-weight: 600; border: none; cursor: pointer;">✅ Accept</a>
                        
                        <a href="/team-invitations/{{ $invitation->token }}/decline" class="btn btn-delete" style="flex: 1; padding: 12px; background: #ef4444; text-decoration: none; text-align: center; font-weight: 600; border: none; cursor: pointer;">❌ Decline</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
