// Initialize theme from localStorage or system preference
function initTheme() {
    const savedTheme = localStorage.getItem('theme') || 'dark';
    const isDark = savedTheme === 'dark';
    
    if (isDark) {
        document.documentElement.classList.add('dark-mode');
    }
}

// Toggle theme with animation
function toggleTheme() {
    // Add animation class
    document.documentElement.classList.add('theme-switching');
    
    // Toggle dark mode
    const isDark = document.documentElement.classList.toggle('dark-mode');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    
    // Update button
    updateThemeButton();
    
    // Remove animation class after animation completes
    setTimeout(() => {
        document.documentElement.classList.remove('theme-switching');
    }, 700);
}

// Update button text
function updateThemeButton() {
    const btn = document.querySelector('.theme-toggle');
    if (!btn) return;
    
    const isDark = document.documentElement.classList.contains('dark-mode');
    btn.textContent = isDark ? '☀️ Light Mode' : '🌙 Dark Mode';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', initTheme);

