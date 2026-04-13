<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
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
            font-size: 24px;
        }

        .message {
            margin-bottom: 30px;
            color: #555;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin: 30px 0;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            text-align: center;
            flex: 1;
            min-width: 150px;
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

        /* Mobile responsiveness */
        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }

            .card {
                padding: 16px;
                border-radius: 8px;
            }

            h1 {
                font-size: 20px;
                margin-bottom: 16px;
            }

            .button-group {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                min-width: 100%;
                padding: 12px 16px;
                flex: auto;
            }

            .message {
                font-size: 14px;
            }

            .team-info {
                padding: 12px;
                margin: 16px 0;
            }

            .footer {
                font-size: 11px;
            }
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
