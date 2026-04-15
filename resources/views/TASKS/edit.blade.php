<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/theme.js') }}"></script>

<div class="container">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1>Edit Task</h1>
            <p>Update task details and settings</p>
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
    <a href="/tasks" style="display: inline-block; margin-bottom: 28px; padding: 10px 16px; background: rgba(23, 162, 184, 0.15); color: var(--info); text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; border: 1px solid rgba(23, 162, 184, 0.3);">← Back to Tasks</a>

    <!-- Form Card -->
    <div class="card" style="padding: 32px; max-width: 600px;">
        <form action="/tasks/{{ $task->id }}" method="POST" style="gap: 24px;">
            @csrf
            @method('PUT')

            <!-- Title Field -->
            <div>
                <label for="title" style="display: block; margin-bottom: 10px; color: white; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Task Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}" placeholder="What do you need to accomplish?" required style="width: 100%;">
                @error('title') <span style="color: var(--danger); font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <!-- Category & Priority Grid -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div>
                    <label for="category" style="display: block; margin-bottom: 10px; color: white; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Category</label>
                    <input type="text" id="category" name="category" value="{{ old('category', $task->category) }}" placeholder="e.g., Work, Personal">
                    @error('category') <span style="color: var(--danger); font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="priority" style="display: block; margin-bottom: 10px; color: white; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Priority</label>
                    <select name="priority" id="priority" style="width: 100%;">
                        <option style="background:#333;" value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>🟢 Low</option>
                        <option style="background:#333;" value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                        <option style="background:#333;" value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>🔴 High</option>
                    </select>
                </div>
            </div>

            <!-- Description Field -->
            <div>
                <label for="description" style="display: block; margin-bottom: 10px; color: white; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Description</label>
                <textarea id="description" name="description" placeholder="Add details about your task...">{{ old('description', $task->description) }}</textarea>
                @error('description') <span style="color: var(--danger); font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <!-- Deadline Field -->
            <div>
                <label for="deadline" style="display: block; margin-bottom: 10px; color: white; font-weight: 700; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Deadline</label>
                <input type="date" id="deadline" name="deadline" value="{{ old('deadline', $task->deadline) }}">
                @error('deadline') <span style="color: var(--danger); font-size: 12px;">{{ $message }}</span> @enderror
            </div>

            <!-- Button Group -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 28px;">
                <a href="/tasks" style="display: flex; align-items: center; justify-content: center; padding: 14px; background: rgba(107, 114, 128, 0.3); color: white; text-decoration: none; border-radius: 10px; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.1); transition: all 0.3s ease;">Cancel</a>
                <button type="submit" class="btn btn-add" style="padding: 14px; font-size: 15px;">✓ Update Task</button>
            </div>
        </form>
    </div>
</div>
