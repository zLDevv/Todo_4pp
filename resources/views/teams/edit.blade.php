<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .form-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 20px;
        }
    }

    @media (max-width: 480px) {
        .form-card {
            padding: 16px;
            border-radius: 10px;
        }

        form button {
            padding: 12px !important;
            font-size: 14px !important;
        }
    }
</style>

<div class="container">
    <div class="dashboard-header">
        <div class="header-content">
            <h1>Edit Team</h1>
            <p>Update your team's information</p>
        </div>
        <div class="header-actions">
            <span class="user-badge">👤 {{ Auth::user()->name }}</span>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <div style="margin-bottom: 30px;">
        <a href="/teams" class="btn" style="background: #6b7280; text-decoration: none;">← Back</a>
    </div>

    <form action="/teams/{{ $team->id }}" method="POST" style="margin-top: 30px;">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 8px; color: white; font-weight: 500;">Team Name</label>
            <input type="text" id="name" name="name" value="{{ $team->name }}" placeholder="Enter team name" required>
        </div>

        <div style="margin-bottom: 30px;">
            <label for="description" style="display: block; margin-bottom: 8px; color: white; font-weight: 500;">Description (Optional)</label>
            <textarea id="description" name="description" placeholder="Enter team description" style="min-height: 100px; padding: 14px; border-radius: 8px; font-family: inherit; font-size: 14px; resize: vertical; transition: all 0.3s ease;">{{ $team->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-add" style="width: 100%; padding: 12px; font-size: 16px;">Update Team</button>
    </form>
</div>
