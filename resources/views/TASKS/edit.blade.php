<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    /* Responsive form styles */
    .form-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .back-link {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 10px 16px;
        text-decoration: none;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }

    .back-link:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .form-card {
            padding: 20px;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .form-group {
            margin-bottom: 20px;
        }
    }

    @media (max-width: 480px) {
        .form-card {
            padding: 16px;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-grid {
            gap: 12px;
            margin-bottom: 18px;
        }

        .back-link {
            padding: 8px 12px;
            font-size: 12px;
            margin-bottom: 20px;
        }

        form button {
            padding: 12px !important;
            font-size: 14px !important;
        }
    }
</style>
<script src="{{ asset('js/theme.js') }}"></script>

<div class="container">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-content">
            <h1>Update Task</h1>
            <p>Update your task</p>
        </div>
        <div class="header-actions">
            <span class="user-badge">👤 {{ Auth::user()->name }}</span>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <a href="/tasks" class="back-link">← Back to Tasks</a>

    <!-- Form Card -->
    <div class="form-card">
        <form action="/tasks/{{ $task->id }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Title Field -->
            <div style="margin-bottom: 25px;">
                <label for="title" style="display: block; margin-bottom: 8px; color: #333; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Task Title *</label>
                <input type="text" id="title" name="title" value="{{ $task->title }}" placeholder="What do you need to do?" required style="width: 100%; padding: 12px; border: 2px solid #000000; background: #fff; color: #333; border-radius: 8px; font-size: 14px; transition: all 0.3s ease;" onfocus="this.style.borderColor='#17a2b8'" onblur="this.style.borderColor='#000000'">
            </div>

            <!-- Priority and Category Grid -->
            <div class="form-grid">
                <div>
                    <label for="priority" style="display: block; margin-bottom: 8px; color: #333; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Priority</label>
                    <select name="priority" id="priority" style="width: 100%; padding: 12px; border: 2px solid #333; border-radius: 8px; background: #fff; color: #333; font-size: 14px; cursor: pointer; transition: all 0.3s ease;" onfocus="this.style.borderColor='#17a2b8'" onblur="this.style.borderColor='#000000'">
                        <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>🟢 Low</option>
                        <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                        <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>🔴 High</option>
                    </select>
                </div>

                <div>
                    <label for="category" style="display: block; margin-bottom: 8px; color: #333; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Category</label>
                    <input type="text" id="category" name="category" value="{{ $task->category }}" placeholder="e.g., Work, Personal" style="width: 100%; padding: 12px; border: 2px solid #000000; background: #fff; color: #333; border-radius: 8px; font-size: 14px; transition: all 0.3s ease;" onfocus="this.style.borderColor='#17a2b8'" onblur="this.style.borderColor='#000000'">
                </div>
            </div>

            <!-- Description Field -->
            <div style="margin-bottom: 25px;">
                <label for="description" style="display: block; margin-bottom: 8px; color: #333; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Description</label>
                <textarea id="description" name="description" placeholder="Add details about your task..." style="width: 100%; min-height: 120px; padding: 12px; border: 2px solid #000000; background: #fff; color: #333; border-radius: 8px; font-family: inherit; font-size: 14px; resize: vertical; transition: all 0.3s ease;" onfocus="this.style.borderColor='#17a2b8'" onblur="this.style.borderColor='#000000'">{{ $task->description }}</textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-add" style="width: 100%; padding: 14px; font-size: 16px; font-weight: 600; border: none; cursor: pointer;">✓ Update Task</button>
        </form>
    </div>
</div>
