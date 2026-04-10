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
            <h1>My Teams</h1>
            <p>Manage and collaborate with your teams</p>
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

    <!-- Create Team Button -->
    <a href="/teams/create" class="btn btn-add" style="width: 100%; padding: 14px; text-align: center; text-decoration: none; font-weight: 600; border: none; cursor: pointer; margin-bottom: 25px;">+ Create New Team</a>

    <!-- Teams You Own Section -->
    @if ($ownedTeams->count() > 0)
        <div style="margin-bottom: 35px;">
            <div style="margin-bottom: 20px;">
                <h2 style="color: white; font-size: 18px; font-weight: 600; margin: 0 0 8px 0;">Teams You Own</h2>
                <p style="color: rgba(255, 255, 255, 0.6); font-size: 13px; margin: 0;">{{ $ownedTeams->count() }} team(s)</p>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                @foreach ($ownedTeams as $team)
                    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); border-left: 4px solid #17a2b8;">
                        <!-- Card Header -->
                        <div style="background: linear-gradient(135deg, rgba(23, 162, 184, 0.1) 0%, rgba(15, 125, 143, 0.1) 100%); padding: 20px;">
                            <h3 style="margin: 0; color: #333; font-size: 18px; font-weight: 700;">{{ $team->name }}</h3>
                            <p style="font-size: 12px; color: #666; margin: 6px 0 0 0; text-transform: uppercase; letter-spacing: 0.5px;">You are the owner</p>
                        </div>

                        <!-- Card Body -->
                        <div style="padding: 20px;">
                            @if ($team->description)
                                <p style="color: #666; font-size: 13px; line-height: 1.6; margin: 0 0 12px 0;">{{ $team->description }}</p>
                            @endif
                            
                            <div style="background: #f3f4f6; padding: 12px; border-radius: 8px; text-align: center;">
                                <p style="color: #666; font-size: 12px; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Members</p>
                                <p style="color: #333; font-size: 20px; font-weight: 700; margin: 0;">{{ $team->members()->count() }}</p>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div style="padding: 0 20px 20px 20px; display: flex; gap: 10px; flex-wrap: wrap;">
                            <a href="/teams/{{ $team->id }}" class="btn btn-done" style="flex: 1; padding: 10px; text-decoration: none; text-align: center; font-weight: 600; border: none; cursor: pointer; font-size: 13px;">Manage</a>
                            <a href="/teams/{{ $team->id }}/edit" class="btn" style="flex: 1; background: #f59e0b; padding: 10px; text-decoration: none; text-align: center; font-weight: 600; border: none; cursor: pointer; font-size: 13px;">Edit</a>
                            <form action="/teams/{{ $team->id }}" method="POST" style="display: flex; flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-delete" onclick="openModal(this)">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Teams You Joined Section -->
    @if ($memberTeams->count() > 0)
        <div style="margin-bottom: 35px;">
            <div style="margin-bottom: 20px;">
                <h2 style="color: white; font-size: 18px; font-weight: 600; margin: 0 0 8px 0;">Teams You Joined</h2>
                <p style="color: rgba(255, 255, 255, 0.6); font-size: 13px; margin: 0;">{{ $memberTeams->count() }} team(s)</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                @foreach ($memberTeams as $team)
                    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); border-left: 4px solid #8b5cf6;">
                        <!-- Card Header -->
                        <div style="background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(107, 33, 168, 0.1) 100%); padding: 20px;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                <h3 style="margin: 0; color: #333; font-size: 18px; font-weight: 700;">{{ $team->name }}</h3>
                                <span style="background: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">Member</span>
                            </div>
                            <p style="font-size: 12px; color: #666; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Managed by {{ $team->owner->name }}</p>
                        </div>

                        <!-- Card Body -->
                        <div style="padding: 20px;">
                            @if ($team->description)
                                <p style="color: #666; font-size: 13px; line-height: 1.6; margin: 0 0 12px 0;">{{ $team->description }}</p>
                            @endif
                            
                            <div style="background: #f3f4f6; padding: 12px; border-radius: 8px; text-align: center;">
                                <p style="color: #666; font-size: 12px; margin: 0 0 4px 0; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Total Members</p>
                                <p style="color: #333; font-size: 20px; font-weight: 700; margin: 0;">{{ $team->members()->count() }}</p>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div style="padding: 0 20px 20px 20px;">
                            <a href="/team-tasks" class="btn btn-done" style="width: 100%; padding: 10px; text-decoration: none; text-align: center; font-weight: 600; border: none; cursor: pointer; font-size: 13px;">View Team Tasks</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Empty State -->
    @if ($ownedTeams->count() === 0 && $memberTeams->count() === 0)
        <div style="background: rgba(255, 255, 255, 0.08); border: 2px dashed rgba(255, 255, 255, 0.2); border-radius: 12px; padding: 60px 20px; text-align: center;">
            <p style="color: rgba(255, 255, 255, 0.6); font-size: 24px; margin: 0 0 12px 0;">👥</p>
            <p style="color: rgba(255, 255, 255, 0.8); margin: 0; font-size: 16px;">No teams yet</p>
            <p style="color: rgba(255, 255, 255, 0.5); margin: 8px 0 0 0; font-size: 13px;"><a href="/teams/create" style="color: #17a2b8; text-decoration: none; font-weight: 600;">Create your first team</a></p>
        </div>
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
