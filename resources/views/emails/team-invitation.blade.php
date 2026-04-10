<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }
        h1 {
            color: #17a2b8;
            margin-bottom: 20px;
        }
        .message {
            margin-bottom: 30px;
            color: #555;
        }
        .button-group {
            display: flex;
            gap: 15px;
            margin: 30px 0;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            text-align: center;
        }
        .btn-accept {
            background: #10b981;
            color: white;
        }
        .btn-decline {
            background: #ef4444;
            color: white;
        }
        .team-info {
            background: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Team Invitation</h1>
            
            <div class="message">
                <p>Hello {{ explode('@', $invitation->email)[0] }},</p>
                <p>You've been invited to join a team!</p>
            </div>

            <div class="team-info">
                <p><strong>Team Name:</strong> {{ $invitation->team->name }}</p>
                @if($invitation->team->description)
                    <p><strong>Description:</strong> {{ $invitation->team->description }}</p>
                @endif
                <p><strong>Invited by:</strong> {{ $invitation->team->owner->name }}</p>
            </div>

            <p>Click the button below to accept or decline the invitation:</p>

            <div class="button-group">
                <a href="{{ route('team-invitations.accept', $invitation->token) }}" class="btn btn-accept">
                    Accept Invitation
                </a>
                <a href="{{ route('team-invitations.decline', $invitation->token) }}" class="btn btn-decline">
                    Decline Invitation
                </a>
            </div>

            <p style="color: #999; font-size: 13px;">
                If you didn't expect this invitation, you can simply ignore this email.
            </p>

            <div class="footer">
                <p>© 2026 Task Manager. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
