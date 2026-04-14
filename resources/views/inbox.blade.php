<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .invitation-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .invitation-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        border-left: 4px solid #17a2b8;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.1) 0%, rgba(15, 125, 143, 0.1) 100%);
        padding: 12px 16px;
    }

    .card-body {
        padding: 12px 16px;
    }

    .card-actions {
        padding: 0 16px 12px 16px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
    }

    .card-actions a {
        padding: 8px 10px;
        text-decoration: none;
        text-align: center;
        font-weight: 600;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        font-size: 11px;
    }

    @media (min-width: 480px) {
        .invitation-grid {
            gap: 14px;
        }

        .card-header {
            padding: 14px 18px;
        }

        .card-header h3 {
            font-size: 15px !important;
        }

        .card-body {
            padding: 14px 18px;
        }

        .card-actions {
            padding: 0 18px 14px 18px;
            gap: 10px;
        }

        .card-actions a {
            padding: 9px 12px;
            font-size: 12px;
        }
    }

    @media (min-width: 768px) {
        .invitation-grid {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .card-header {
            padding: 20px;
        }

        .card-header h3 {
            font-size: 17px !important;
        }

        .card-body {
            padding: 20px;
        }

        .card-actions {
            padding: 0 20px 20px 20px;
            gap: 10px;
        }

        .card-actions a {
            padding: 12px 14px;
            font-size: 13px;
        }
    }

    .card-body p {
            font-size: 12px !important;
        }

        .card-actions {
            padding: 0 12px 12px 12px;
            flex-direction: column;
        }

        .card-actions a {
            width: 100%;
            padding: 10px !important;
            font-size: 12px !important;
        }
    }
</style>
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
        <div class="invitation-grid">
            @foreach ($invitations as $invitation)
                <div class="invitation-card">
                    <!-- Card Header -->
                    <div class="card-header">
                        <h3 style="margin: 0 0 8px 0; color: #17a2b8; font-size: 18px; font-weight: 700;">🤝 {{ $invitation->team->name }}</h3>
                        @if ($invitation->team->description)
                            <p style="font-size: 13px; color: #666; margin: 8px 0 0 0;">{{ $invitation->team->description }}</p>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <div style="background: #f3f4f6; padding: 12px; border-radius: 8px; margin-bottom: 16px;">
                            <p style="color: #666; font-size: 12px; margin: 0 0 6px 0; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">👤 Invited by</p>
                            <p style="color: #333; font-size: 14px; font-weight: 600; margin: 0;">{{ $invitation->team->owner->name ?? 'Unknown' }}</p>
                        </div>

                        <p style="color: #666; font-size: 13px; line-height: 1.6;">You've been invited to join the <strong>{{ $invitation->team->name }}</strong> team. Accept to start collaborating or decline to skip.</p>
                    </div>

                    <!-- Card Actions -->
                    <div class="card-actions">
                        <a href="/team-invitations/{{ $invitation->token }}/accept" class="btn btn-done" style="background: #10b981; color: white;">✅ Accept</a>
                        <a href="/team-invitations/{{ $invitation->token }}/decline" class="btn btn-delete" style="background: #ef4444; color: white;">❌ Decline</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
