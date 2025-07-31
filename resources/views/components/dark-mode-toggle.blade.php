<button 
    id="darkModeToggle" 
    class="flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors duration-200"
    title="Alternar modo escuro"
>
    <!-- Ícone Sol (modo claro) -->
    <i class="fas fa-sun text-yellow-500 dark:hidden"></i>
    <!-- Ícone Lua (modo escuro) -->
    <i class="fas fa-moon text-blue-400 hidden dark:block"></i>
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const html = document.documentElement;
    
    // Verificar se há preferência salva
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    // Aplicar tema inicial
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }
    
    // Toggle do dark mode
    darkModeToggle.addEventListener('click', function() {
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            html.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    });
});
</script> 