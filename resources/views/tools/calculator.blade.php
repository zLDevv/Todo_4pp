<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator - Task Manager</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/theme.js') }}"></script>
</head>
<body>

<div class="container">
    <div class="dashboard-header">
        <div class="header-content">
            <h1>Calculator</h1>
            <p>Perform mathematical calculations with ease</p>
        </div>
        <div class="header-actions">
            <span class="user-badge">👤 {{ Auth::user()->name }}</span>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <div class="card" style="padding: 30px;">
        <form method="GET" style="gap: 20px;">
            <!-- Input Numbers Section -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #666; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">First Number</label>
                    <input type="number" name="a" placeholder="Enter number" value="{{ request('a') }}" step="any" style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 15px; transition: all 0.3s ease;" onfocus="this.style.borderColor='#17a2b8'; this.style.boxShadow='0 0 0 3px rgba(23, 162, 184, 0.1)';" onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';">
                </div>
                
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 600; color: #666; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Second Number</label>
                    <input type="number" name="b" placeholder="Enter number" value="{{ request('b') }}" step="any" style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 15px; transition: all 0.3s ease;" onfocus="this.style.borderColor='#17a2b8'; this.style.boxShadow='0 0 0 3px rgba(23, 162, 184, 0.1)';" onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';">
                </div>
            </div>

            <!-- Operation Selection -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: #666; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Operation</label>
                <select name="op" style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 15px; background: white; color: #333; cursor: pointer; transition: all 0.3s ease;" onfocus="this.style.borderColor='#17a2b8'; this.style.boxShadow='0 0 0 3px rgba(23, 162, 184, 0.1)';" onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none';">
                    <option value="+" {{ request('op') == '+' ? 'selected' : '' }}>➕ Addition (+)</option>
                    <option value="-" {{ request('op') == '-' ? 'selected' : '' }}>➖ Subtraction (-)</option>
                    <option value="*" {{ request('op') == '*' ? 'selected' : '' }}>✖️ Multiplication (×)</option>
                    <option value="/" {{ request('op') == '/' ? 'selected' : '' }}>➗ Division (÷)</option>
                </select>
            </div>

            <!-- Calculate Button -->
            <button type="submit" class="btn btn-add" style="width: 100%; padding: 14px; font-size: 15px; font-weight: 600; border: none; cursor: pointer; margin-top: 10px;">
                🧮 Calculate
            </button>
        </form>

        <!-- Result Section -->
        @if(request('a') !== null && request('b') !== null)
            @php
                $a = request('a');
                $b = request('b');
                $op = request('op');
                $result = 0;
                $formula = $a . ' ' . $op . ' ' . $b;

                if ($op == '+') {
                    $result = $a + $b;
                } elseif ($op == '-') {
                    $result = $a - $b;
                } elseif ($op == '*') {
                    $result = $a * $b;
                } elseif ($op == '/') {
                    $result = $b != 0 ? $a / $b : 'Error (Division by zero)';
                }
            @endphp

            <div style="margin-top: 30px; padding-top: 25px; border-top: 2px solid #e0e0e0;">
                <p style="color: #999; font-size: 12px; margin-bottom: 12px; text-align: center; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">📊 Result</p>
                <div style="background: linear-gradient(135deg, #17a2b8 0%, #0f7d8f 100%); padding: 25px; border-radius: 12px; text-align: center; box-shadow: 0 10px 30px rgba(23, 162, 184, 0.2);">
                    <p style="color: rgba(255, 255, 255, 0.85); font-size: 13px; margin-bottom: 10px; letter-spacing: 0.5px;">{{ $formula }}</p>
                    <h2 style="color: white; font-size: 38px; font-weight: 800; margin: 0; letter-spacing: -0.5px;">
                        @if(is_numeric($result))
                            {{ number_format($result, 2, '.', '') }}
                        @else
                            {{ $result }}
                        @endif
                    </h2>
                </div>
            </div>
        @endif
    </div>

    <div style="margin-top: 25px; text-align: center;">
        <a href="/tasks" class="btn" style="background: rgba(255, 255, 255, 0.15); color: white; text-decoration: none; padding: 11px 22px; border-radius: 8px; display: inline-block; transition: all 0.3s ease; border: 1px solid rgba(255, 255, 255, 0.2);" onmouseover="this.style.background='rgba(255, 255, 255, 0.25)'; this.style.borderColor='rgba(255, 255, 255, 0.3)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.borderColor='rgba(255, 255, 255, 0.2)';">
            ← Back to Tasks
        </a>
    </div>
</div>

</body>
</html>

