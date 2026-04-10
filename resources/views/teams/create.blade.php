<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<div class="container">
    <div class="dashboard-header">
        <div class="header-content">
            <h1>Create Team</h1>
            <p>Create your team and collaborate effectively</p>
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

    <form action="/teams" method="POST" style="margin-top: 30px;">
        @csrf

        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 8px; color: white; font-weight: 500;">Team Name</label>
            <input type="text" id="name" name="name" placeholder="Enter team name" required>
        </div>

        <!-- Description Field -->
        <div style="margin-bottom: 25px;">
            <label for="description" style="display: block; margin-bottom: 8px; color: #ffffff; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Description</label>
            <textarea id="description" name="description" placeholder="Add team description..." style="width: 100%; background: #fff; color: #333; min-height: 120px; padding: 12px; border: 2px solid rgb(0, 0, 0); border-radius: 8px; font-family: inherit; font-size: 14px; resize: vertical; transition: all 0.3s ease;" onfocus="this.style.borderColor='#17a2b8'" onblur="this.style.borderColor='#000000'"></textarea>
            </div>

        <button type="submit" class="btn btn-add" style="width: 100%; padding: 12px; font-size: 16px;">Create Team</button>
    </form>
</div>
