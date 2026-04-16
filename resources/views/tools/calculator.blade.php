<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
    .calculator {
        max-width: 100%;
        width: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.85));
        border-radius: 10px;
        padding: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.5);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    html.dark-mode .calculator {
        background: linear-gradient(135deg, rgba(42, 42, 42, 0.9), rgba(30, 30, 30, 0.9));
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    @media (min-width: 480px) {
        .calculator {
            max-width: 500px;
            padding: 16px;
            border-radius: 11px;
        }
    }

    @media (min-width: 768px) {
        .calculator {
            max-width: 600px;
            padding: 24px;
            border-radius: 14px;
        }
    }

    .calc-display {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 12px;
        text-align: right;
        border: 1px solid rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    html.dark-mode .calc-display {
        background: rgba(0, 0, 0, 0.2);
        border-color: rgba(255, 255, 255, 0.1);
    }

    @media (min-width: 480px) {
        .calc-display {
            padding: 14px;
            margin-bottom: 16px;
            border-radius: 10px;
        }
    }

    @media (min-width: 768px) {
        .calc-display {
            padding: 16px;
            margin-bottom: 20px;
            border-radius: 12px;
        }
    }

    .calc-formula {
        color: #6b7280;
        font-size: 10px;
        margin-bottom: 4px;
        min-height: 14px;
    }

    html.dark-mode .calc-formula {
        color: #a0a0a0;
    }

    @media (min-width: 480px) {
        .calc-formula {
            font-size: 12px;
            margin-bottom: 5px;
        }
    }

    @media (min-width: 768px) {
        .calc-formula {
            font-size: 13px;
            margin-bottom: 6px;
        }
    }

    .calc-result {
        color: var(--text-light);
        font-size: 28px;
        font-weight: 600;
        word-break: break-all;
    }

    html.dark-mode .calc-result {
        color: var(--text-dark);
    }

    @media (min-width: 480px) {
        .calc-result {
            font-size: 32px;
        }
    }

    @media (min-width: 768px) {
        .calc-result {
            font-size: 42px;
        }
    }

    .calc-buttons {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 6px;
    }

    @media (min-width: 768px) {
        .calc-buttons {
            gap: 8px;
        }
    }

    .calc-btn {
        background: rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.1);
        color: var(--text-light);
        padding: 12px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        width: 100%;
    }

    @media (min-width: 480px) {
        .calc-btn {
            padding: 14px;
            font-size: 16px;
            border-radius: 7px;
        }
    }

    @media (min-width: 768px) {
        .calc-btn {
            padding: 16px;
            font-size: 18px;
            border-radius: 8px;
        }
    }

    .calc-btn:hover {
        background: rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .calc-btn:active {
        transform: translateY(0);
    }

    html.dark-mode .calc-btn {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.1);
        color: var(--text-dark);
    }

    html.dark-mode .calc-btn:hover {
        background: rgba(255, 255, 255, 0.12);
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
    }

    .calc-btn.operator {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .calc-btn.operator:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
    }

    .calc-btn.equals {
        background: #10b981;
        border-color: #10b981;
        color: white;
        grid-column: span 2;
    }

    .calc-btn.equals:hover {
        background: #059669;
        border-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .calc-btn.clear {
        background: #ef4444;
        border-color: #ef4444;
        color: white;
    }

    .calc-btn.clear:hover {
        background: #dc2626;
        border-color: #dc2626;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .back-section {
        text-align: left;
        margin-bottom: 20px;
        background: rgb(0, 126, 119);
        padding: 10px 16px;
        border-radius: 6px;
        width: 100px;

    }

    .back-link {
        color: #ffffff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .back-link:hover {
        color: var(--primary-dark);
        transform: translateX(-2px);
    }

    /* Tablet */
    @media (max-width: 768px) {
        .calculator {
            max-width: 380px;
            padding: 20px;
        }

        .calc-display {
            padding: 14px;
            margin-bottom: 16px;
        }

        .calc-result {
            font-size: 38px;
        }

        .calc-buttons {
            gap: 7px;
        }

        .calc-btn {
            padding: 14px;
            font-size: 16px;
        }
    }

    /* Mobile */
    @media (max-width: 480px) {
        .calculator {
            max-width: 100%;
            padding: 16px;
            margin: 0;
            border-radius: 12px;
        }

        .calc-display {
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 8px;
        }

        .calc-formula {
            font-size: 12px;
            margin-bottom: 4px;
        }

        .calc-result {
            font-size: 32px;
        }

        .calc-buttons {
            gap: 6px;
        }

        .calc-btn {
            padding: 12px;
            font-size: 15px;
            border-radius: 6px;
        }
    }

    /* Extra small */
    @media (max-width: 360px) {
        .calculator {
            padding: 12px;
        }

        .calc-display {
            padding: 10px;
            margin-bottom: 10px;
        }

        .calc-result {
            font-size: 28px;
        }

        .calc-buttons {
            gap: 5px;
        }

        .calc-btn {
            padding: 10px;
            font-size: 13px;
        }
    }
</style>
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

    <div class="back-section">
        <a href="#" onclick="window.history.back(); return false;" class="back-link">← Back</a>
    </div>

    <div class="calculator">

        <!-- DISPLAY -->
        <div class="calc-display">
            <div class="calc-formula" id="formula"></div>
            <div class="calc-result" id="display">0</div>
        </div>

        <!-- BUTTONS -->
        <div class="calc-buttons">

            <button class="calc-btn clear" onclick="clearDisplay()">C</button>
            <button class="calc-btn clear" onclick="backspace()">←</button>
            <button class="calc-btn operator" onclick="setOperator('/')">÷</button>
            <button class="calc-btn operator" onclick="setOperator('*')">×</button>

            <button class="calc-btn" onclick="appendNumber('7')">7</button>
            <button class="calc-btn" onclick="appendNumber('8')">8</button>
            <button class="calc-btn" onclick="appendNumber('9')">9</button>
            <button class="calc-btn operator" onclick="setOperator('-')">−</button>

            <button class="calc-btn" onclick="appendNumber('4')">4</button>
            <button class="calc-btn" onclick="appendNumber('5')">5</button>
            <button class="calc-btn" onclick="appendNumber('6')">6</button>
            <button class="calc-btn operator" onclick="setOperator('+')">+</button>

            <button class="calc-btn" onclick="appendNumber('1')">1</button>
            <button class="calc-btn" onclick="appendNumber('2')">2</button>
            <button class="calc-btn" onclick="appendNumber('3')">3</button>
            <button class="calc-btn equals" onclick="calculate()">=</button>

            <button class="calc-btn" onclick="appendNumber('0')">0</button>
            <button class="calc-btn" onclick="appendNumber('.')">.</button>

        </div>
    </div>
</div>

<script>
    let display = document.getElementById('display');
    let formula = document.getElementById('formula');

    let currentValue = '0';
    let operator = null;
    let previousValue = null;
    let shouldReset = false;

    function updateDisplay() {
        display.textContent = currentValue.length > 10 ? currentValue.substring(0, 10) + '...' : currentValue;
    }

    function appendNumber(num) {
        if (shouldReset) {
            currentValue = num;
            shouldReset = false;
        } else {
            if (currentValue === '0' && num !== '.') {
                currentValue = num;
            } else if (num === '.' && currentValue.includes('.')) {
                return;
            } else {
                currentValue += num;
            }
        }
        updateDisplay();
    }

    function setOperator(op) {
        if (operator !== null && !shouldReset) {
            calculate();
        }
        previousValue = currentValue;
        operator = op;
        shouldReset = true;
        formula.textContent = previousValue + ' ' + op;
    }

    function calculate() {
        if (!operator || !previousValue) return;

        let result;
        let prev = parseFloat(previousValue);
        let curr = parseFloat(currentValue);

        switch (operator) {
            case '+': result = prev + curr; break;
            case '-': result = prev - curr; break;
            case '*': result = prev * curr; break;
            case '/': result = curr !== 0 ? prev / curr : 'Error'; break;
        }

        currentValue = result.toString();
        operator = null;
        previousValue = null;
        shouldReset = true;
        formula.textContent = '';
        updateDisplay();
    }

    function clearDisplay() {
        currentValue = '0';
        operator = null;
        previousValue = null;
        shouldReset = false;
        formula.textContent = '';
        updateDisplay();
    }

    function backspace() {
        if (currentValue.length > 1) {
            currentValue = currentValue.slice(0, -1);
        } else {
            currentValue = '0';
        }
        updateDisplay();
    }
</script>