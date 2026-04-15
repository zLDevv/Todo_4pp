<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/theme.js') }}"></script>

<div class="container">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1>Create Team Task</h1>
            <p>Assign a task to your team</p>
        </div>
        <div class="header-actions">
            <span class="user-badge">👤 {{ Auth::user()->name }}</span>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <!-- Back Link -->
    <a href="/team-tasks" style="display: inline-block; margin-bottom: 28px; padding: 10px 16px; background: rgba(23, 162, 184, 0.15); color: var(--info); text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; border: 1px solid rgba(23, 162, 184, 0.3);">← Back to Team Tasks</a>

    <!-- Form Card -->
    <div class="card" style="padding: 32px; max-width: 600px;">
        <form action="/tasks" method="POST" style="gap: 24px;">
            @csrf

            <!-- Team Selection -->
            <div>
                <label for="team_id" style="display: block; margin-bottom: 10px; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Select Team</label>
                <select id="team_id" name="team_id" required style="width: 100%;">
                    <option value="" style="background:#333;">Choose a team...</option>
                    <optgroup label="Teams You Own" style="background:#333;">
                        @foreach ($ownedTeams as $team)
                            <option value="{{ $team->id }}" style="background:#333;">{{ $team->name }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Teams You Joined" style="background:#333;">
                        @foreach ($memberTeams as $team)
                            <option value="{{ $team->id }}" style="background:#333;">{{ $team->name }}</option>
                        @endforeach
                    </optgroup>
                </select>
                @error('team_id') <span style="color: var(--danger); font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <!-- Title Field -->
            <div>
                <label for="title" style="display: block; margin-bottom: 10px; color: white; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Task Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="What needs to be done?" required style="width: 100%;">
                @error('title') <span style="color: var(--danger); font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <!-- Category & Priority Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label for="category" style="display: block; margin-bottom: 10px; color: white; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Category</label>
                    <input type="text" id="category" name="category" value="{{ old('category') }}" placeholder="e.g., Work, Personal" required>
                    @error('category') <span style="color: var(--danger); font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="priority" style="display: block; margin-bottom: 10px; color: white; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Priority</label>
                    <select name="priority" id="priority" style="width: 100%;">
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }} style="background:#333;">🟢 Low</option>
                        <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }} style="background:#333;">🟡 Medium</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }} style="background:#333;">🔴 High</option>
                    </select>
                </div>
            </div>

            <!-- Description Field -->
            <div>
                <label for="description" style="display: block; margin-bottom: 10px; color: white; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Description</label>
                <textarea id="description" name="description" placeholder="Add task details...">{{ old('description') }}</textarea>
                @error('description') <span style="color: var(--danger); font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <!-- Deadline Field -->
            <div>
                <label for="deadline" style="display: block; margin-bottom: 10px; color: white; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Deadline</label>
                <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}" required style="width: 100%;">
                @error('deadline') <span style="color: var(--danger); font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <!-- Button Group -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 28px;">
                <a href="/team-tasks" style="display: flex; align-items: center; justify-content: center; padding: 14px; background: rgba(107, 114, 128, 0.3); color: white; text-decoration: none; border-radius: 10px; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.3s ease;">Cancel</a>
                <button type="submit" class="btn btn-add" style="padding: 14px; font-size: 15px;">✓ Create Task</button>
            </div>
        </form>
    </div>
</div>
