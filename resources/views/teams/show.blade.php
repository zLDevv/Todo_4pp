<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .team-header {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .team-header h1 {
        margin: 0;
        flex: 1;
        min-width: 200px;
    }

    .team-header-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    @media (max-width: 768px) {
        .team-header {
            flex-direction: column;
            gap: 10px;
        }

        .team-header h1 {
            width: 100%;
            text-align: center;
        }

        .team-header-actions {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .team-header h1 {
            font-size: 1.2em !important;
        }

        .team-header-actions {
            flex-direction: column;
        }

        .team-header-actions span,
        .team-header-actions form {
            width: 100%;
            text-align: center;
        }

        .team-header-actions button {
            width: 100%;
        }
    }
</style>>
@if(session('success'))
    <div id="toast" style="background:#10b981;color:white;padding:14px 16px;margin-bottom:20px;border-radius:8px;font-weight:500;box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);animation: slideIn 0.3s ease;">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('toast').style.display = 'none';
        }, 3000);
    </script>
@endif

@if(session('error'))
    <div id="error-toast" style="background:#ef4444;color:white;padding:14px 16px;margin-bottom:20px;border-radius:8px;font-weight:500;box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);animation: slideIn 0.3s ease;">
        {{ session('error') }}
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('error-toast').style.display = 'none';
        }, 3000);
    </script>
@endif

<div class="container">
    <div class="team-header">
        <h1 style="margin: 0;">{{ $team->name }}</h1>
        <div class="team-header-actions">
            <span style="color: white; font-size: 14px;">👤  {{ Auth::user()->name }}</span>
            <form action="/logout" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn" style="background: #ef4444; padding: 8px 12px; margin: 0; font-size: 13px;">Logout</button>
            </form>
        </div>
    </div>

    <div style="margin-bottom: 30px;">
        <a href="/teams" class="btn" style="background: #6b7280; text-decoration: none;">← Back</a>
    </div>

    @if ($team->description)
        <div class="card" style="margin-bottom: 20px; background: #f3f4f6;">
            <p style="margin: 0; color: #374151;">{{ $team->description }}</p>
        </div>
    @endif

    <!-- Invite Member Section -->
    <div class="card" style="margin-bottom: 20px;">
        <h3 style="margin: 0 0 15px 0; color: #1f2937;">➕ Invite Member</h3>
        
        <form action="/teams/{{ $team->id }}/invite-member" method="POST" style="display: flex; gap: 10px;">
            @csrf
            <div style="flex: 1; display: flex; flex-direction: column; gap: 8px;">
                <input type="email" name="email" placeholder="Enter member's email" required style="padding: 12px 14px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-family: inherit; transition: all 0.3s ease; background: white;">
                <button type="submit" class="btn btn-add" style="padding: 10px 16px;">📧 Send Invitation</button>
            </div>
        </form>
    </div>

    <!-- Pending Invitations -->
    @if ($invitations->count() > 0)
        <div class="card" style="margin-bottom: 20px;">
            <h3 style="margin: 0 0 15px 0; color: #1f2937;">⏳ Pending Invitations</h3>
            
            <div style="border-top: 1px solid #e5e7eb; padding-top: 15px;">
                @foreach ($invitations as $invitation)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
                        <div>
                            <p style="margin: 0; color: #1f2937; font-weight: 500;">{{ $invitation->email }}</p>
                            <p style="margin: 4px 0 0 0; color: #9ca3af; font-size: 13px;">Invitation sent {{ $invitation->created_at->diffForHumans() }}</p>
                        </div>
                        <span style="background: #fef3c7; color: #92400e; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 500;">Pending</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Members List -->
    <div class="card">
        <h3 style="margin: 0 0 15px 0; color: #1f2937;">Team Members ({{ $team->members()->count() }})</h3>
        
        @if ($team->members()->count() === 0)
            <p style="color: #9ca3af; margin: 0;">No members yet</p>
        @else
            <div style="border-top: 1px solid #e5e7eb; padding-top: 15px;">
                @foreach ($team->members as $member)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #e5e7eb;">
                        <div>
                            <p style="margin: 0; color: #1f2937; font-weight: 500;">
                                {{ $member->name }}
                                @if ($member->id === $team->user_id)
                                    <span style="background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 4px; font-size: 11px; margin-left: 8px;">Owner</span>
                                @endif
                            </p>
                            <p style="margin: 4px 0 0 0; color: #9ca3af; font-size: 13px;">{{ $member->email }}</p>
                        </div>
                        @if ($member->id !== Auth::id() && $member->id !== $team->user_id)
                            <form action="/teams/{{ $team->id }}/members/{{ $member->id }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" style="background: #ef4444; padding: 8px 12px; font-size: 13px;" onclick="return confirm('Remove this member?')">Remove</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
