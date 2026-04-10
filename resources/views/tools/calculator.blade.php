<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/theme.js') }}"></script>

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

    <div style="background: rgba(255, 255, 255, 0.95); border-radius: 16px; padding: 40px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);">
        <form method="GET" style="gap: 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div style="display: flex; flex-direction: column;">
                    <label style="font-size: 12px; font-weight: 600; color: #666; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Angka Pertama</label>
                    <input type="number" name="a" placeholder="Masukkan angka" value="{{ request('a') }}" step="any" style="padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: all 0.3s ease;" onfocus="this.style.borderColor='#17a2b8';" onblur="this.style.borderColor='#e0e0e0';">
                </div>
                
                <div style="display: flex; flex-direction: column;">
                    <label style="font-size: 12px; font-weight: 600; color: #666; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Angka Kedua</label>
                    <input type="number" name="b" placeholder="Masukkan angka" value="{{ request('b') }}" step="any" style="padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; transition: all 0.3s ease;" onfocus="this.style.borderColor='#17a2b8';" onblur="this.style.borderColor='#e0e0e0';">
                </div>
            </div>

            <div style="display: flex; flex-direction: column;">
                <label style="font-size: 12px; font-weight: 600; color: #666; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Operasi</label>
                <select name="op" style="padding: 14px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 16px; background: white; cursor: pointer; transition: all 0.3s ease;" onfocus="this.style.borderColor='#17a2b8';" onblur="this.style.borderColor='#e0e0e0';">
                    <option value="+" {{ request('op') == '+' ? 'selected' : '' }}>➕ Tambah (+)</option>
                    <option value="-" {{ request('op') == '-' ? 'selected' : '' }}>➖ Kurang (-)</option>
                    <option value="*" {{ request('op') == '*' ? 'selected' : '' }}>✖️ Kali (×)</option>
                    <option value="/" {{ request('op') == '/' ? 'selected' : '' }}>➗ Bagi (÷)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-add" style="width: 100%; padding: 14px; font-size: 16px; font-weight: 600; border: none; cursor: pointer; margin-top: 10px;">Hitung Sekarang</button>
        </form>

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
                    $result = $b != 0 ? $a / $b : 'Error (tidak bisa dibagi 0)';
                }
            @endphp

            <div style="margin-top: 30px; padding-top: 30px; border-top: 2px solid #e0e0e0;">
                <p style="color: #666; font-size: 14px; margin-bottom: 12px; text-align: center;">📊 Hasil Perhitungan</p>
                <div style="background: linear-gradient(135deg, #17a2b8 0%, #0f7d8f 100%); padding: 24px; border-radius: 12px; text-align: center;">
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 14px; margin-bottom: 8px;">{{ $formula }}</p>
                    <h2 style="color: white; font-size: 36px; font-weight: 700; margin: 0;">
                        @if(is_numeric($result))
                            {{ number_format($result, 2, ',', '.') }}
                        @else
                            {{ $result }}
                        @endif
                    </h2>
                </div>
            </div>
        @endif
    </div>

    <div style="margin-top: 30px; text-align: center;">
        <a href="/tasks" class="btn" style="background: rgba(255, 255, 255, 0.2); color: white; text-decoration: none; padding: 12px 24px; border-radius: 8px; display: inline-block; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)';">← Kembali ke Tugas</a>
    </div>
</div>

